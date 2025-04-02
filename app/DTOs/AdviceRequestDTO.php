<?php

namespace App\DTOs;

class AdviceRequestDTO
{
    /**
     * @param array $countries
     * @param string $startDate
     * @param string $endDate
     */
    public function __construct(
        public array $countries,
        public string $startDate,
        public string $endDate
    ) {}

    /**
     * @param array $data
     * @return self
     */
    public static function fromRequest(array $data): self
    {
        return new self(
            $data['countries'],
            $data['start_date'],
            $data['end_date']
        );
    }
}
