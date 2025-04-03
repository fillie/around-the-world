<?php

namespace Tests\Unit\Jobs;

use App\Builders\AdvicePromptBuilder;
use App\Clients\OpenAIClient;
use App\DTOs\AdviceRequestDTO;
use App\Jobs\GenerateAdviceJob;
use App\Models\Advice;
use App\Repositories\Contracts\AdviceRepositoryInterface;
use Mockery;
use Psr\Log\LoggerInterface;
use Tests\TestCase;

class GenerateAdviceJobTest extends TestCase
{
    public function test_handle_calls_openai_and_updates_advice()
    {
        // Arrange
        $dto = new AdviceRequestDTO([
            'France'
        ],
            '2025-03-01',
            '2025-03-10'
        );
        $advice = Mockery::mock(Advice::class);
        $repository = Mockery::mock(AdviceRepositoryInterface::class);
        $openAi = Mockery::mock(OpenAIClient::class);
        $logger = Mockery::mock(LoggerInterface::class);

        $prompt = (new AdvicePromptBuilder())->build($dto);
        $response = 'Generated advice from OpenAI';

        $openAi->shouldReceive('requestCompletion')
            ->once()
            ->with($prompt)
            ->andReturn($response);

        $repository->shouldReceive('update')
            ->once()
            ->with($advice, $response);

        $job = new GenerateAdviceJob($dto, $advice, $repository);
        $job->handle($openAi, $logger);
        $this->assertTrue(true);
    }

    public function test_handle_logs_error_if_openai_throws_exception()
    {
        $dto = new AdviceRequestDTO([
            'Spain'
        ],
            '2025-03-01',
            '2025-03-10'
        );
        $advice = Mockery::mock(Advice::class);
        $repository = Mockery::mock(AdviceRepositoryInterface::class);
        $openAI = Mockery::mock(OpenAIClient::class);
        $logger = Mockery::mock(LoggerInterface::class);

        $prompt = (new AdvicePromptBuilder())->build($dto);

        $openAI->shouldReceive('requestCompletion')
            ->with($prompt)
            ->andThrow(new \Exception('AI failure'));

        $logger->shouldReceive('error')
            ->once()
            ->with('AI failure');

        $job = new GenerateAdviceJob($dto, $advice, $repository);
        $job->handle($openAI, $logger);
        $this->assertTrue(true);
    }
}
