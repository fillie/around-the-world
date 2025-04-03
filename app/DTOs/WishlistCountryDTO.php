<?php

namespace App\DTOs;

use App\Models\Country;

readonly class WishlistCountryDTO
{
    /**
     * @param Country $country
     * @param string $startDate
     * @param string $endDate
     * @param string|null $notes
     */
    public function __construct(
        public Country $country,
        public string  $startDate,
        public string  $endDate,
        public ?string $notes,
    ) {}
}
