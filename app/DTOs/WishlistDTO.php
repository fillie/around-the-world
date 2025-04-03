<?php

namespace App\DTOs;

use App\Models\User;

final class WishlistDTO
{
    /**
     * @param User $user
     * @param string $name
     * @param string $notes
     * @param array $countries
     */
    public function __construct(
        public User $user,
        public string $name,
        public string $notes,
        public array $countries
    ) {}
}
