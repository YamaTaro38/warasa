<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\ImageService;

class GenerateImageJob implements ShouldQueue
{
    use Queueable;
    
    protected $prompt;
    protected $aspectRatio;
    protected $index;
    
    public function __construct($prompt, $aspectRatio, $index)
    {
        $this->prompt = $prompt;
        $this->aspectRatio = $aspectRatio;
        $this->index = $index;
    }
    
    public function handle(ImageService $imageService)
    {
        $imageService->generateImage($this->prompt, $this->aspectRatio);
    }
}