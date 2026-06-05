<?php

namespace App\Services;

use App\Models\ApiKey;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MultiProviderAIService extends AIService
{
    /**
     * Mendapatkan API key Gemini yang aktif dan belum limit
     * @return string|null
     */
    protected function getAvailableGeminiKey()
    {
        $activeKey = ApiKey::active('gemini')->first();
        if ($activeKey) {
            return $activeKey->key;
        }
        return null;
    }

    /**
     * Menandai key sebagai limited
     */
    protected function markKeyAsLimited($apiKey)
    {
        $keyModel = ApiKey::where('key', $apiKey)->first();
        if ($keyModel) {
            $keyModel->markAsLimited();
            Log::warning("Gemini API key marked as limited: " . substr($apiKey, 0, 10) . "...");
        }
    }

    /**
     * Cek apakah suatu Gemini key masih valid (tidak limit)
     * Panggil API sederhana, misalnya list models
     */
    public function checkGeminiKeyLimit($apiKey)
    {
        try {
            $url = "https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}";
            $response = Http::timeout(10)->get($url);
            
            if ($response->successful()) {
                return true; // key masih aktif
            }
            
            // Jika response 429 (Too Many Requests) atau 403 (quota exceeded)
            if ($response->status() === 429 || $response->status() === 403) {
                return false; // limit
            }
            
            // Untuk status lain, anggap sementara error tapi mungkin bukan limit
            // Bisa tetap dianggap aktif, tapi kita catat
            Log::warning("Gemini key check returned status: " . $response->status());
            return true;
            
        } catch (\Exception $e) {
            Log::error("Error checking Gemini key: " . $e->getMessage());
            return false; // jika gagal konek, kita anggap tidak valid untuk sementara
        }
    }

    /**
     * Cek semua Gemini keys dan update statusnya
     * Panggil dari cron setiap jam
     */
    public function checkAllGeminiKeys()
    {
        $keys = ApiKey::where('provider', 'gemini')->get();
        foreach ($keys as $keyModel) {
            $isActive = $this->checkGeminiKeyLimit($keyModel->key);
            if (!$isActive) {
                $keyModel->markAsLimited();
            } else {
                // Jika sebelumnya limited, bisa reactivate (opsional)
                if ($keyModel->status === 'limited') {
                    $keyModel->markAsActive();
                    Log::info("Gemini key reactivated: " . substr($keyModel->key, 0, 10) . "...");
                }
            }
        }
    }

    /**
     * Override callGemini untuk menggunakan multi key
     */
    protected function callGemini($prompt, $timeout, $minLength = 10)
    {
        // Ambil semua key aktif (prioritas tertinggi dulu)
        $activeKeys = ApiKey::active('gemini')->get();
        
        if ($activeKeys->isEmpty()) {
            Log::warning("No active Gemini keys available");
            return null;
        }
        
        foreach ($activeKeys as $keyModel) {
            $apiKey = $keyModel->key;
            for ($attempt = 1; $attempt <= $this->maxRetries; $attempt++) {
                try {
                    $model = 'gemini-2.5-flash';
                    $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";
                    
                    $response = Http::timeout($timeout)->post($url, [
                        'contents' => [['parts' => [['text' => $prompt]]]],
                        'generationConfig' => ['temperature' => 0.8, 'maxOutputTokens' => 4096]
                    ]);
                    
                    if ($response->successful()) {
                        $data = $response->json();
                        $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                        if ($content && strlen(trim($content)) >= $minLength) {
                            Log::info("Gemini response from key: " . substr($apiKey, 0, 10) . "...");
                            return $content;
                        }
                    } else {
                        $status = $response->status();
                        Log::warning("Gemini attempt with key " . substr($apiKey, 0, 10) . " failed: HTTP {$status}");
                        
                        // Jika limit, tandai key dan lanjut ke key berikutnya
                        if ($status === 429 || $status === 403) {
                            $this->markKeyAsLimited($apiKey);
                            break; // berhenti coba dengan key ini, lanjut key berikutnya
                        }
                    }
                } catch (\Exception $e) {
                    Log::warning("Gemini attempt with key " . substr($apiKey, 0, 10) . " exception: " . $e->getMessage());
                    if ($attempt >= $this->maxRetries) {
                        // Jika sudah retry dan gagal, tandai key? optional
                        // $this->markKeyAsLimited($apiKey);
                    }
                }
                if ($attempt < $this->maxRetries) sleep(1);
            }
        }
        
        // Jika semua key gagal, return null sehingga fallback ke Pollinations
        Log::error("All Gemini keys failed");
        return null;
    }
}