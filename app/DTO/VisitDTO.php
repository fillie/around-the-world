<?php

namespace App\DTO;

final class VisitDTO
{
    public function __construct(
        public int $country_id,
        public string $date_visited,
        public int $length_of_visit,
        public ?string $notes
    ) {}
}
