<?php

namespace App\Services;

use App\DTOs\AdviceRequestDTO;
use App\Jobs\GenerateAdviceJob;
use App\Models\Advice;
use App\Models\User;
use App\Repositories\Contracts\AdviceRepositoryInterface;
use Carbon\Carbon;

readonly class AdviceService
{
    /**
     * Inject the repository into the service.
     */
    public function __construct(
        private AdviceRepositoryInterface $adviceRepository,
    ) {}

    /**
     * @param AdviceRequestDTO $adviceRequest
     * @param User $user
     * @return Advice
     */
    public function create(AdviceRequestDTO $adviceRequest, User $user): Advice
    {
        // todo implement user
        $adviceRecord = $this->adviceRepository->create(
            $user,
            $adviceRequest->countries[0],
            Carbon::parse($adviceRequest->startDate),
            Carbon::parse($adviceRequest->endDate)
        );

        GenerateAdviceJob::dispatch($adviceRequest, $adviceRecord, $this->adviceRepository);

        return $adviceRecord;
    }
}
