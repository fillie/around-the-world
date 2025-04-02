<?php

namespace App\Builders;

use App\DTOs\AdviceRequestDTO;

class AdvicePromptBuilder
{
    /**
     * @param AdviceRequestDTO $adviceRequest
     * @return string
     */
    public static function build(AdviceRequestDTO $adviceRequest): string
    {
        $countries = implode(', ', $adviceRequest->countries);
        return "Generate travel advice for {$countries} from {$adviceRequest->startDate} to {$adviceRequest->endDate}";
    }
}
