<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MultiProviderAIService;
use App\Services\AIService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Text Generator (Pollinations)
        $this->app->singleton(AIService::class, function ($app) {
            return new AIService();
        });

        $this->app->bind(AIService::class, MultiProviderAIService::class);
    }

    public function boot(): void
    {
        Paginator::useTailwind();

        // Force HTTPS scheme for all generated URLs on Vercel
        if (app()->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Auto-migrate & seed SQLite on Vercel if database is missing/empty
        if (app()->environment('production') && config('database.default') === 'sqlite') {
            try {
                if (!file_exists(config('database.connections.sqlite.database'))) {
                    Artisan::call('migrate', ['--force' => true]);
                    Artisan::call('db:seed', ['--force' => true]);
                }
            } catch (\Exception $e) {
                // Silent fail - don't break the app
                \Log::warning('Auto-migrate failed: ' . $e->getMessage());
            }
        }
    }
}