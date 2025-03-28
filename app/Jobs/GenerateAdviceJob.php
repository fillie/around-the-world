<?php

namespace App\Jobs;

use App\Clients\OpenAIClient;
use App\Builders\AdvicePromptBuilder;
use App\DTOs\AdviceRequestDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerateAdviceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private readonly AdviceRequestDTO $dto,
    ) {}

    public function handle(OpenAIClient $openAIClient): void
    {
        $prompt = (new AdvicePromptBuilder())->build($this->dto);
        try {
            Log::info($openAIClient->requestCompletion($prompt));
        } Catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
