<?php

namespace App\DTOs;

final class VisitDTO
{
    public function __construct(
        public int $country_id,
        public string $date_visited,
        public int $length_of_visit,
        public ?string $notes
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            $data['country_id'],
            $data['date_visited'],
            $data['length_of_visit'],
            $data['notes'],
        );
    }
}
