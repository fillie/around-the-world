<?php

namespace App\Mappers;

use App\DTOs\WishlistDTO;
use App\DTOs\WishlistCountryDTO;
use App\Repositories\Contracts\CountryRepositoryInterface;
use Illuminate\Http\Request;

class WishlistMapper
{
    /**
     * @param CountryRepositoryInterface $countryRepository
     */
    public function __construct(
        protected CountryRepositoryInterface $countryRepository
    ) {}

    /**
     * @param Request $request
     * @return WishlistDTO
     */
    public function mapRequestToWishlistDTO(Request $request): WishlistDTO
    {
        $countries = array_map(
            function (array $data): WishlistCountryDTO {
                return new WishlistCountryDTO(
                    country: $this->countryRepository->find((int)$data['country_id']),
                    startDate: $data['start_date'],
                    endDate: $data['end_date'],
                    notes: $data['notes'] ?? null
                );
            },
            $request->input('countries', [])
        );

        return new WishlistDTO(
            user: $request->user(),
            name: $request->input('name'),
            notes: $request->input('notes'),
            countries: $countries
        );
    }
}
