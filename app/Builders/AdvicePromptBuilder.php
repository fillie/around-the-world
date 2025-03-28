<?php

namespace App\Builders;

use App\DTOs\AdviceRequestDTO;

class AdvicePromptBuilder
{
    public static function build(AdviceRequestDTO $dto): string
    {
        $countries = implode(', ', $dto->countries);

        return "
            Generate travel advice for {$countries}
            from {$dto->startDate} to {$dto->endDate}";
    }
}
