<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MultiProviderAIService;
use App\Services\AIService;
use Illuminate\Pagination\Paginator;

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
    }
}