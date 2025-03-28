<?php

namespace App\Services;

use App\DTOs\AdviceRequestDTO;
use App\Jobs\GenerateAdviceJob;

class AdviceService
{
    public function generateAdvice(AdviceRequestDTO $dto): void
    {
        GenerateAdviceJob::dispatch($dto);
    }
}
