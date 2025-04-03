<?php

namespace App\Jobs;

use App\Clients\OpenAiClient;
use App\Builders\AdvicePromptBuilder;
use App\DTOs\AdviceRequestDTO;
use App\Models\Advice;
use App\Repositories\Contracts\AdviceRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Exception;
use Psr\Log\LoggerInterface;

class GenerateAdviceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @param AdviceRequestDTO $adviceRequest
     * @param Advice $adviceRecord
     * @param AdviceRepositoryInterface $adviceRepository
     */
    public function __construct(
        private readonly AdviceRequestDTO $adviceRequest,
        private readonly Advice $adviceRecord,
        private readonly AdviceRepositoryInterface $adviceRepository,
    ) {}

    /**
     * @param OpenAIClient $openAIClient
     * @param LoggerInterface $logger
     * @return void
     */
    public function handle(OpenAiClient $openAIClient, LoggerInterface $logger): void
    {
        try {
            $prompt = (new AdvicePromptBuilder())->build($this->adviceRequest);
            $this->adviceRepository->update($this->adviceRecord, $openAIClient->requestCompletion($prompt));
        } catch (Exception $e) {
            $logger->error($e->getMessage());
        }
    }
}
