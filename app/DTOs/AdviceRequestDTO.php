<?php

namespace App\DTOs;

class AdviceRequestDTO
{
    public function __construct(
        public array $countries,
        public string $startDate,
        public string $endDate
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            $data['countries'],
            $data['start_date'],
            $data['end_date']
        );
    }
}
