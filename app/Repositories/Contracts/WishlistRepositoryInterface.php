<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Collection;

interface WishlistRepositoryInterface
{
    /**
     * Retrieve all Wishlist records.
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param User $user
     * @param string $name
     * @param string|null $notes
     * @param array $countries
     * @return Wishlist
     */
    public function create(
        User $user,
        string $name,
        ?string $notes,
        array $countries
    ): Wishlist;

    /**
     * @param Wishlist $wishlist
     * @param string $name
     * @param string|null $notes
     * @param array $countries
     * @return Wishlist     */
    public function update(
        Wishlist $wishlist,
        string $name,
        ?string $notes,
        array $countries
    ): Wishlist;

    /**
     * Delete the given Wishlist.
     *
     * @param Wishlist $wishlist
     * @return bool
     */
    public function delete(Wishlist $wishlist): bool;

    /**
     * Find a Wishlist by its ID.
     *
     * @param int $id
     * @return Wishlist|null
     */
    public function find(int $id): ?Wishlist;
}
