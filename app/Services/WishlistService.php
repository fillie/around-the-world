<?php

namespace App\Services;

use App\Models\Wishlist;
use App\DTOs\WishlistDTO;
use App\Repositories\Contracts\WishlistRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

readonly class WishlistService
{
    /**
     * @param WishlistRepositoryInterface $wishlistRepository
     */
    public function __construct(
        private WishlistRepositoryInterface $wishlistRepository,
    ) {}

    /**
     * @param WishlistDTO $wishlistDTO
     * @return Wishlist
     */
    public function createWishlist(WishlistDTO $wishlistDTO): Wishlist
    {
        return $this->wishlistRepository->create(
            $wishlistDTO->user,
            $wishlistDTO->name,
            $wishlistDTO->notes,
            array_map(
                fn($wishlistCountryDTO) => [
                    'country_id' => $wishlistCountryDTO->country->id,
                    'start_date' => $wishlistCountryDTO->startDate,
                    'end_date' => $wishlistCountryDTO->endDate,
                    'notes' => $wishlistCountryDTO->notes,
                ],
                $wishlistDTO->countries
            )
        );
    }

    /**
     * @param Wishlist $wishlist
     * @param WishlistDTO $wishlistDTO
     * @return Wishlist
     */
    public function updateWishlist(Wishlist $wishlist, WishlistDTO $wishlistDTO): Wishlist
    {
        return $this->wishlistRepository->update(
            $wishlist,
            $wishlistDTO->name,
            $wishlistDTO->notes,
            array_map(
                fn($wishlistCountryDTO) => [
                    'country_id' => $wishlistCountryDTO->country->id,
                    'start_date' => $wishlistCountryDTO->startDate,
                    'end_date' => $wishlistCountryDTO->endDate,
                    'notes' => $wishlistCountryDTO->notes,
                ],
                $wishlistDTO->countries
            )
        );
    }

    /**
     * @param Wishlist $wishlist
     * @return bool
     */
    public function deleteWishlist(Wishlist $wishlist): bool
    {
        return $this->wishlistRepository->delete($wishlist);
    }

    /**
     * @return Collection
     */
    public function getAllWishlists(): Collection
    {
        return $this->wishlistRepository->all();
    }
}
