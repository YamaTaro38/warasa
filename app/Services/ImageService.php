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

    /**
     * Generate single image dengan prompt yang di-enhance
     */
    public function generateImage($prompt)
    {
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
                    
                    // Terapkan watermark jika user mengaktifkan
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

    /**
     * Generate multiple images dengan angle berbeda - DETAIL PRODUK SAMA
     * Gunakan informasi tambahan untuk memperkaya prompt
     */
    public function generateMultipleImages($basePrompt, $count = 1, $additionalInfo = null)
    {
        $images = [];
        $maxCount = min($count, 3);
        
        // Enhance base prompt dengan informasi tambahan
        $enhancedBasePrompt = $this->enhancePromptWithInfo($basePrompt, $additionalInfo);
        
        // Angle variations untuk multiple images
        $angleVariations = [
            1 => [
                'angle' => 'front view, straight on shot',
                'desc' => 'Tampak depan produk'
            ],
            2 => [
                'angle' => 'three-quarter angled view, product slightly turned',
                'desc' => 'Sudut tiga perempat'
            ],
            3 => [
                'angle' => 'side angle, showing depth and dimension',
                'desc' => 'Tampak samping'
            ],
            4 => [
                'angle' => 'close up detail shot, macro view of texture',
                'desc' => 'Detail close-up'
            ],
            5 => [
                'angle' => 'top down flat lay view',
                'desc' => 'Tampak atas'
            ],
            6 => [
                'angle' => 'lifestyle shot, product in use context',
                'desc' => 'Lifestyle'
            ],
        ];
        
        for ($i = 1; $i <= $maxCount; $i++) {
            // Pilih angle berdasarkan urutan
            $angleIndex = (($i - 1) % count($angleVariations)) + 1;
            $angle = $angleVariations[$angleIndex];
            
            // Build prompt dengan angle spesifik
            $fullPrompt = $enhancedBasePrompt . ", " . $angle['angle'] . ", professional product photography";
            
            Log::info("Generating image {$i}/{$maxCount}", [
                'angle' => $angle['desc'],
                'prompt' => substr($fullPrompt, 0, 100)
            ]);
            
            $imageUrl = $this->generateImage($fullPrompt);
            
            if ($imageUrl && !str_contains($imageUrl, 'placehold.co')) {
                $images[] = $imageUrl;
            } else {
                // Fallback: jika gagal, coba dengan prompt yang lebih sederhana
                $simplePrompt = $enhancedBasePrompt . ", " . $angle['angle'];
                $retryUrl = $this->generateImage($simplePrompt);
                if ($retryUrl && !str_contains($retryUrl, 'placehold.co')) {
                    $images[] = $retryUrl;
                } else {
                    $images[] = $this->getPlaceholderImage($basePrompt);
                }
            }
            
            // Delay antar request agar tidak overload
            if ($i < $maxCount) {
                sleep(2);
            }
        }
        
        return $images;
    }

    /**
     * Enhance prompt dengan informasi tambahan dari user
     */
    protected function enhancePromptWithInfo($basePrompt, $additionalInfo = null)
    {
        $enhanced = $basePrompt;
        
        if ($additionalInfo) {
            // Ekstrak informasi penting dari additional info
            $enhanced .= ". Product details: " . $additionalInfo;
        }
        
        // Tambahkan quality keywords
        $qualityKeywords = "high quality, 4k resolution, sharp focus, professional photography, clean background, well lit, commercial product shot, bold typography";
        
        return $enhanced . " " . $qualityKeywords;
    }

    /**
     * Generate product image dengan informasi lengkap
     */
    public function generateProductImage($productName, $additionalInfo = null, $angle = 'front view')
    {
        $basePrompt = "professional product photography of {$productName}";
        
        if ($additionalInfo) {
            $basePrompt .= ", {$additionalInfo}";
        }
        
        $fullPrompt = $basePrompt . ", {$angle}, high quality, 4k, sharp focus, studio lighting, clean white background";
        
        return $this->generateImage($fullPrompt);
    }

    /**
     * Cek apakah user mengaktifkan watermark (dari profil atau default)
     * @return bool
     */
    protected function shouldApplyWatermark()
    {
        // Cek dari user yang login
        if (Auth::check() && Auth::user()->watermark_enabled) {
            return true;
        }
        // Atau bisa juga dari config default
        return config('services.watermark.default_enabled', false);
    }

    /**
     * Terapkan watermark pada gambar jika user mengaktifkan
     * @param string $imagePath URL atau path gambar
     * @return string URL gambar yang sudah di-watermark (atau original jika gagal)
     */
    protected function applyWatermarkIfNeeded($imagePath)
    {
        if (!$this->shouldApplyWatermark()) {
            return $imagePath;
        }

        // Ubah URL menjadi path lokal
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

    /**
     * Terapkan watermark teks atau gambar pada file gambar
     * @param string $imagePath Path absolut file gambar
     * @return string Path file yang sudah di-watermark
     */
    public function applyWatermark($imagePath)
    {
        // Cek apakah extension GD tersedia
        if (!extension_loaded('gd')) {
            Log::warning('GD extension not loaded, watermark skipped');
            return $imagePath;
        }

        // Tentukan posisi watermark (default bottom-right)
        $position = config('services.watermark.position', 'bottom-right');
        
        // Baca gambar sesuai tipe
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
        
        // Buat watermark teks (atau bisa dari file gambar)
        $watermarkText = config('services.watermark.text', Auth::user()->store_name ?? Auth::user()->name ?? 'Warasa');
        $fontSize = 5; // ukuran font GD (1-5)
        $fontPath = public_path('fonts/arial.ttf'); // optional untuk true type
        
        // Hitung dimensi teks
        $textWidth = imagefontwidth($fontSize) * strlen($watermarkText);
        $textHeight = imagefontheight($fontSize);
        
        $imgWidth = imagesx($image);
        $imgHeight = imagesy($image);
        
        // Tentukan koordinat
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
        
        // Warna watermark (putih dengan opacity)
        $color = imagecolorallocatealpha($image, 255, 255, 255, 50);
        
        // Gambar teks
        imagestring($image, $fontSize, $x, $y, $watermarkText, $color);
        
        // Simpan gambar (timpa asli atau buat baru)
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

    /**
     * Konversi URL public ke path lokal storage
     */
    protected function urlToLocalPath($url)
    {
        $relativePath = str_replace(asset('storage/'), 'storage/', $url);
        $relativePath = str_replace('/storage/', 'storage/', $relativePath);
        $fullPath = storage_path('app/public/' . str_replace('storage/', '', $relativePath));
        
        return file_exists($fullPath) ? $fullPath : null;
    }

    /**
     * Konversi path lokal ke URL public
     */
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