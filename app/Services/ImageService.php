<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ImageService
{
    protected $workerUrl;
    protected $workerToken;

    public function __construct()
    {
        $this->workerUrl = config('services.cloudflare_worker.url');
        $this->workerToken = config('services.cloudflare_worker.token');
    }

    protected function isVercel()
    {
        // Metode paling handal: langsung cek writability storage
        // Vercel readonly - path storage tidak bisa ditulisi
        // Solusi: treat all non-local environments as readonly
        try {
            $testDir = storage_path('app/public');
            if (!is_dir($testDir)) {
                return true;
            }
            // Coba tulis test file
            $testFile = $testDir . '/.vercel_test_' . uniqid();
            $written = @file_put_contents($testFile, '1');
            if ($written === false) {
                return true;
            }
            @unlink($testFile);
            return false;
        } catch (\Exception $e) {
            return true;
        }
    }

    public function generateImage($prompt)
    {
        if ($this->isVercel()) {
            return $this->getPlaceholderImage($prompt);
        }

        $cacheKey = 'img_' . md5($prompt);

        $cached = Cache::get($cacheKey);
        if ($cached && $this->imageExists($cached)) {
            return $cached;
        }

        try {
            $response = Http::timeout(60)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->workerToken,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->workerUrl, [
                    'prompt' => $prompt
                ]);

            if ($response->successful()) {
                $imageContent = $response->body();

                if ($this->isValidImage($imageContent)) {
                    $savedPath = $this->saveImage($imageContent);
                    $savedPath = $this->applyWatermarkIfNeeded($savedPath);
                    Cache::put($cacheKey, $savedPath, now()->addDays(7));
                    return $savedPath;
                }
            }

            return $this->getPlaceholderImage($prompt);

        } catch (\Exception $e) {
            Log::error('Cloudflare Worker error: ' . $e->getMessage());
            return $this->getPlaceholderImage($prompt);
        }
    }

    public function generateMultipleImages($basePrompt, $count = 1, $additionalInfo = null)
    {
        // Vercel: langsung return placeholder, tidak ada write file
        if ($this->isVercel()) {
            $images = [];
            for ($i = 0; $i < min($count, 3); $i++) {
                $images[] = $this->getPlaceholderImage($basePrompt);
            }
            return $images;
        }

        $images = [];
        $maxCount = min($count, 3);

        $enhancedBasePrompt = $this->enhancePromptWithInfo($basePrompt, $additionalInfo);

        $angleVariations = [
            1 => ['angle' => 'front view, straight on shot', 'desc' => 'Tampak depan produk'],
            2 => ['angle' => 'three-quarter angled view, product slightly turned', 'desc' => 'Tampak tiga perempat'],
            3 => ['angle' => 'side angle, showing depth and dimension', 'desc' => 'Tampak samping'],
        ];

        for ($i = 1; $i <= $maxCount; $i++) {
            if ($this->isVercel()) {
                $images[] = $this->getPlaceholderImage($basePrompt);
                continue;
            }

            $angleIndex = (($i - 1) % count($angleVariations)) + 1;
            $angle = $angleVariations[$angleIndex];
            $fullPrompt = $enhancedBasePrompt . ", " . $angle['angle'] . ", professional product photography";

            $imageUrl = $this->generateImage($fullPrompt);

            if ($imageUrl && !str_contains($imageUrl, 'placehold.co')) {
                $images[] = $imageUrl;
            } else {
                $simplePrompt = $enhancedBasePrompt . ", " . $angle['angle'];
                $retryUrl = $this->generateImage($simplePrompt);
                if ($retryUrl && !str_contains($retryUrl, 'placehold.co')) {
                    $images[] = $retryUrl;
                } else {
                    $images[] = $this->getPlaceholderImage($basePrompt);
                }
            }

            if ($i < $maxCount) {
                sleep(2);
            }
        }

        return $images;
    }

    protected function enhancePromptWithInfo($basePrompt, $additionalInfo = null)
    {
        $enhanced = $basePrompt;
        if ($additionalInfo) {
            $enhanced .= ". Product details: " . $additionalInfo;
        }
        $qualityKeywords = "high quality, 4k resolution, sharp focus, professional photography, clean background, well lit, commercial product shot";
        return $enhanced . " " . $qualityKeywords;
    }

    public function generateProductImage($productName, $additionalInfo = null, $angle = 'front view')
    {
        $basePrompt = "professional product photography of {$productName}";
        if ($additionalInfo) {
            $basePrompt .= ", {$additionalInfo}";
        }
        $fullPrompt = $basePrompt . ", {$angle}, high quality, 4k, sharp focus, studio lighting, clean white background";
        return $this->generateImage($fullPrompt);
    }

    protected function shouldApplyWatermark()
    {
        if (Auth::check() && Auth::user()->watermark_enabled) {
            return true;
        }
        return config('services.watermark.default_enabled', false);
    }

    protected function applyWatermarkIfNeeded($imagePath)
    {
        if (!$this->shouldApplyWatermark()) {
            return $imagePath;
        }

        $localPath = $this->urlToLocalPath($imagePath);
        if (!$localPath || !file_exists($localPath)) {
            Log::warning('Watermark skipped: image not found locally', ['path' => $imagePath]);
            return $imagePath;
        }

        try {
            $watermarkedPath = $this->applyWatermark($localPath);
            return $this->localPathToUrl($watermarkedPath);
        } catch (\Exception $e) {
            Log::error('Watermark application failed: ' . $e->getMessage());
            return $imagePath;
        }
    }

    public function applyWatermark($imagePath)
    {
        if (!extension_loaded('gd')) {
            Log::warning('GD extension not loaded, watermark skipped');
            return $imagePath;
        }

        $position = config('services.watermark.position', 'bottom-right');

        $info = getimagesize($imagePath);
        if (!$info) {
            throw new \Exception('Cannot read image info');
        }

        switch ($info[2]) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($imagePath);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($imagePath);
                break;
            default:
                throw new \Exception('Unsupported image type');
        }

        $watermarkText = config('services.watermark.text', Auth::user()->store_name ?? Auth::user()->name ?? 'Warasa');
        $fontSize = 5;
        $textWidth = imagefontwidth($fontSize) * strlen($watermarkText);
        $textHeight = imagefontheight($fontSize);
        $imgWidth = imagesx($image);
        $imgHeight = imagesy($image);

        switch ($position) {
            case 'bottom-right':
                $x = $imgWidth - $textWidth - 10;
                $y = $imgHeight - $textHeight - 10;
                break;
            case 'bottom-left':
                $x = 10;
                $y = $imgHeight - $textHeight - 10;
                break;
            case 'top-right':
                $x = $imgWidth - $textWidth - 10;
                $y = 10;
                break;
            case 'top-left':
                $x = 10;
                $y = 10;
                break;
            default:
                $x = $imgWidth - $textWidth - 10;
                $y = $imgHeight - $textHeight - 10;
        }

        $color = imagecolorallocatealpha($image, 255, 255, 255, 50);
        imagestring($image, $fontSize, $x, $y, $watermarkText, $color);

        $ext = pathinfo($imagePath, PATHINFO_EXTENSION);
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                imagejpeg($image, $imagePath, 90);
                break;
            case 'png':
                imagepng($image, $imagePath, 9);
                break;
        }

        imagedestroy($image);
        return $imagePath;
    }

    protected function urlToLocalPath($url)
    {
        $relativePath = str_replace(asset('storage/'), 'storage/', $url);
        $relativePath = str_replace('/storage/', 'storage/', $relativePath);
        $fullPath = storage_path('app/public/' . str_replace('storage/', '', $relativePath));
        return file_exists($fullPath) ? $fullPath : null;
    }

    protected function localPathToUrl($localPath)
    {
        $relative = str_replace(storage_path('app/public/'), '', $localPath);
        return asset('storage/' . $relative);
    }

    protected function isValidImage($content)
    {
        return strlen($content) > 5000 && !str_contains($content, '<!DOCTYPE') && !str_contains($content, 'error');
    }

    protected function saveImage($imageContent)
    {
        $filename = 'products/' . date('Y/m/d') . '/' . Str::random(40) . '.png';
        $fullPath = storage_path('app/public/' . $filename);

        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0777, true);
        }

        file_put_contents($fullPath, $imageContent);
        return asset('storage/' . $filename);
    }

    protected function imageExists($path)
    {
        $relativePath = str_replace(asset('storage/'), 'storage/', $path);
        $relativePath = str_replace('/storage/', 'storage/', $relativePath);
        return Storage::disk('public')->exists($relativePath);
    }

    protected function getPlaceholderImage($prompt)
    {
        return "https://placehold.co/1024x1024/ee4d2d/white?text=Generating...";
    }
}