<?php

namespace Tests\Unit\Repositories\Eloquent;

use App\Models\Country;
use App\Models\User;
use App\Repositories\Eloquent\EloquentWishlistRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class EloquentWishlistRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_stores_data_correctly(): void
    {
        $user = User::factory()->create();
        $country = Country::find(1);
        $repo = new EloquentWishlistRepository();
        $wishlist = $repo->create(
            $user,
            'My Wishlist',
            'Some notes',
            [
                [
                    'country_id' => $country->id,
                    'start_date' => '2025-01-01',
                    'end_date' => '2025-01-10',
                    'notes' => 'Country notes',
                ],
            ]
        );

        $this->assertDatabaseHas('wishlists', [
            'id' => $wishlist->id,
            'user_id' => $user->id,
            'name' => 'My Wishlist',
            'notes' => 'Some notes',
        ]);

        $this->assertDatabaseHas('wishlist_country', [
            'wishlist_id' => $wishlist->id,
            'country_id' => $country->id,
            'start_date' => '2025-01-01',
            'end_date' => '2025-01-10',
            'notes' => 'Country notes',
        ]);
    }

    public function test_update_modifies_data_correctly(): void
    {
        $user = User::factory()->create();
        $country1 = Country::find(2);
        $country2 = Country::find(3);
        $repo = new EloquentWishlistRepository();
        $wishlist = $repo->create(
            $user,
            'Initial Wishlist',
            'Initial notes',
            [
                [
                    'country_id' => $country1->id,
                    'start_date' => '2025-01-01',
                    'end_date' => '2025-01-10',
                    'notes' => 'Initial country note',
                ],
            ]
        );

        $repo->update(
            $wishlist,
            'Updated Wishlist',
            'Updated notes',
            [
                [
                    'country_id' => $country2->id,
                    'start_date' => '2025-02-01',
                    'end_date' => '2025-02-10',
                    'notes' => 'Updated country note',
                ],
            ]
        );

        $this->assertDatabaseHas('wishlists', [
            'id' => $wishlist->id,
            'name' => 'Updated Wishlist',
            'notes' => 'Updated notes',
        ]);

        $this->assertDatabaseHas('wishlist_country', [
            'wishlist_id' => $wishlist->id,
            'country_id' => $country2->id,
            'start_date' => '2025-02-01',
            'end_date' => '2025-02-10',
            'notes' => 'Updated country note',
        ]);

        $this->assertDatabaseMissing('wishlist_country', [
            'wishlist_id' => $wishlist->id,
            'country_id' => $country1->id,
        ]);
    }

    public function test_delete_removes_wishlist(): void
    {
        $user = User::factory()->create();
        $repo = new EloquentWishlistRepository();
        $wishlist = $repo->create(
            $user,
            'To be deleted',
            null,
            []
        );
        $result = $repo->delete($wishlist);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('wishlists', ['id' => $wishlist->id]);
    }

    public function test_find_returns_wishlist(): void
    {
        $user = User::factory()->create();
        $repo = new EloquentWishlistRepository();
        $wishlist = $repo->create(
            $user,
            'Find me',
            'Some notes',
            []
        );
        $found = $repo->find($wishlist->id);

        $this->assertNotNull($found);
        $this->assertEquals($wishlist->id, $found->id);
    }

    public function test_all_returns_owned_scope(): void
    {
        $user = User::factory()->create();
        $this->be($user);
        $repo = new EloquentWishlistRepository();
        $repo->create(
            $user,
            'Wishlist 1',
            'Notes',
            []
        );
        $result = $repo->all();

        $this->assertInstanceOf(Collection::class, $result);
        $this->assertGreaterThan(0, $result->count());
    }
}
