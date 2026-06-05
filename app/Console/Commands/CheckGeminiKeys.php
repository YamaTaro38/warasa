<?php

namespace App\Console\Commands;

use App\Services\MultiProviderAIService;
use Illuminate\Console\Command;

class CheckGeminiKeys extends Command
{
    protected $signature = 'gemini:check-keys';
    protected $description = 'Check all Gemini API keys and mark limited ones';

    protected $aiService;

    public function __construct(MultiProviderAIService $aiService)
    {
        parent::__construct();
        $this->aiService = $aiService;
    }

    public function handle()
    {
        $this->info('Checking all Gemini API keys...');
        $this->aiService->checkAllGeminiKeys();
        $this->info('Done.');
    }
}