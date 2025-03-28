<?php

namespace App\DTOs;

use App\Models\User;

final class VisitDTO
{
    /**
     * @param User $user
     * @param int $countryId
     * @param string $dateVisited
     * @param int $lengthOfVisit
     * @param string|null $notes #
     */
    public function __construct(
        public User $user,
        public int $countryId,
        public string $dateVisited,
        public int $lengthOfVisit,
        public ?string $notes
    ) {}
}
