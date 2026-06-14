<?php

namespace Database\Seeders;

use App\Models\ApiKey;
use Illuminate\Database\Seeder;

class ApiKeySeeder extends Seeder
{
    public function run()
    {
        // Baca API key dari environment variable GEMINI_API_KEYS (comma-separated)
        // Set di Vercel Dashboard, tidak di-commit ke GitHub
        $keysFromEnv = env('GEMINI_API_KEYS', '');
        
        $keys = [];
        
        if (!empty($keysFromEnv)) {
            $keyArray = explode(',', $keysFromEnv);
            foreach ($keyArray as $key) {
                $key = trim($key);
                if (!empty($key)) {
                    $keys[] = [
                        'provider' => 'gemini',
                        'key' => $key,
                        'priority' => 50,
                    ];
                }
            }
        }

        foreach ($keys as $key) {
            if ($key['key']) {
                ApiKey::updateOrCreate(
                    ['key' => $key['key']],
                    ['provider' => $key['provider'], 'priority' => $key['priority'], 'status' => 'active']
                );
            }
        }
    }
}