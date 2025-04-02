<?php

namespace Tests\Unit\Services;

use App\DTOs\AdviceRequestDTO;
use App\Jobs\GenerateAdviceJob;
use App\Models\Advice;
use App\Models\User;
use App\Repositories\Contracts\AdviceRepositoryInterface;
use App\Services\AdviceService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Bus;
use Mockery;
use Tests\TestCase;
use ReflectionClass;

class AdviceServiceTest extends TestCase
{
    public function test_create_dispatches_generate_advice_job_with_correct_arguments()
    {
        $adviceRequestDTO = new AdviceRequestDTO(
            ['United Kingdom'],
            Carbon::now()->toDateString(),
            Carbon::now()->toTimeString()
        );

        Bus::fake();

        $mockUser = Mockery::mock(User::class);
        $mockAdvice = Mockery::mock(Advice::class);
        $mockRepository = Mockery::mock(AdviceRepositoryInterface::class);
        $mockRepository->shouldReceive('create')
            ->with(
                $mockUser,
                'United Kingdom',
                Mockery::type(Carbon::class),
                Mockery::type(Carbon::class)
            )
            ->andReturn($mockAdvice);

        $service = new AdviceService($mockRepository);

        $result = $service->create($adviceRequestDTO, $mockUser);

        Bus::assertDispatched(GenerateAdviceJob::class, function ($job) use ($adviceRequestDTO, $mockAdvice, $mockRepository) {
            $reflection = new ReflectionClass($job);

            $adviceRequestProp = $reflection->getProperty('adviceRequest');
            $adviceProp = $reflection->getProperty('adviceRecord');
            $adviceRepositoryProp = $reflection->getProperty('adviceRepository');

            return $adviceRequestProp->getValue($job) === $adviceRequestDTO &&
                $adviceProp->getValue($job) === $mockAdvice &&
                $adviceRepositoryProp->getValue($job) === $mockRepository;
        });

        $this->assertSame($mockAdvice, $result);
    }
}
