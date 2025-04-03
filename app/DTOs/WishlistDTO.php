<?php

namespace App\DTOs;

use App\Http\Requests\StoreWishlistRequest;
use App\Models\Country;
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
        public array  $countries,
    ) {}

    /**
     * Create a DTO from a form request.
     *
     * @param StoreWishlistRequest $request
     * @return self
     */
    public static function fromRequest(StoreWishlistRequest $request): self
    {
        $countries = array_map(function ($data) {
            return new WishlistCountryDTO(
                country: Country::find($data['country_id']),
                startDate: $data['start_date'],
                endDate: $data['end_date'],
                notes: $data['notes'] ?? null,
            );
        }, $request->input('countries', []));

        return new self(
            user: $request->user(),
            name: $request->input('name'),
            notes: $request->input('notes'),
            countries: $countries
        );
    }
}
