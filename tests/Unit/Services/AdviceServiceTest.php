<?php

namespace Tests\Unit\Services;

use App\DTOs\AdviceRequestDTO;
use App\Jobs\GenerateAdviceJob;
use App\Services\AdviceService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;
use ReflectionClass;

class AdviceServiceTest extends TestCase
{
    public function test_generate_advice_dispatches_generate_advice_job()
    {
        $adviceRequestDTO = new AdviceRequestDTO([
                'United Kingdom'
            ],
            Carbon::now()->toDateString(),
            Carbon::now()->toTimeString(),
        );

        Bus::fake();
        $service = new AdviceService();
        $service->generateAdvice($adviceRequestDTO);

        Bus::assertDispatched(GenerateAdviceJob::class, function ($job) use ($adviceRequestDTO) {
            $reflection = new ReflectionClass($job);
            $property = $reflection->getProperty('adviceRequest');
            return $property->getValue($job) === $adviceRequestDTO;
        });
    }
}
