<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Models\Wishlist;
use App\Repositories\Contracts\WishlistRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class EloquentWishlistRepository implements WishlistRepositoryInterface
{
    /**
     * Retrieve all Wishlist records.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Wishlist::owned()->get();
    }

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
    ): Wishlist {
        $wishlist = Wishlist::create([
            'user_id' => $user->id,
            'name'  => $name,
            'notes' => $notes,
        ]);

        foreach ($countries as $country) {
            $wishlist->countries()->attach($country['country_id'], [
                'start_date' => $country['start_date'],
                'end_date' => $country['end_date'],
                'notes' => $country['notes'] ?? null,
            ]);
        }

        $wishlist->load('countries');
        return $wishlist;
    }

    /**
     * @param Wishlist $wishlist
     * @param string $name
     * @param string|null $notes
     * @param array $countries
     * @return Wishlist
     */
    public function update(
        Wishlist $wishlist,
        string $name,
        ?string $notes,
        array $countries
    ): Wishlist {
        $wishlist->update([
            'name' => $name,
            'notes' => $notes,
        ]);

        $syncData = [];
        foreach ($countries as $country) {
            $syncData[$country['country_id']] = [
                'start_date' => $country['start_date'],
                'end_date' => $country['end_date'],
                'notes' => $country['notes'] ?? null,
            ];
        }

        $wishlist->countries()->sync($syncData);
        $wishlist->load('countries');

        return $wishlist;
    }

    /**
     * Delete the given Wishlist record.
     *
     * @param Wishlist $wishlist
     * @return bool
     */
    public function delete(Wishlist $wishlist): bool
    {
        return $wishlist->delete();
    }

    /**
     * Find a Wishlist by its ID.
     *
     * @param int $id
     * @return Wishlist|null
     */
    public function find(int $id): ?Wishlist
    {
        return Wishlist::find($id);
    }
}
