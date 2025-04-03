<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistScopeTest extends TestCase
{
    use RefreshDatabase;

    public function testOwnedScopeReturnsOnlyUserWishlists(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        Wishlist::factory()->count(3)->create([
            'user_id' => $user->id
        ]);
        Wishlist::factory()->count(2)->create([
            'user_id' => $otherUser->id
        ]);

        $this->actingAs($user);
        $ownedWishlists = Wishlist::owned()->get();

        $this->assertCount(3, $ownedWishlists);
        foreach ($ownedWishlists as $wishlist) {
            $this->assertEquals($user->id, $wishlist->user_id);
        }
    }
}
