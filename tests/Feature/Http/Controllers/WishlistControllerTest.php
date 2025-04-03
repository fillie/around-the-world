<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WishlistControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_index_returns_all_wishlists()
    {
        $country = Country::find(1);
        $wishlist = Wishlist::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'Trip',
            'notes' => 'Overall trip note'
        ]);
        $wishlist->countries()->attach($country->id, [
            'start_date' => '2025-06-01',
            'end_date' => '2025-06-10',
            'notes' => 'Country specific note'
        ]);
        Wishlist::factory()->count(2)->create(['user_id' => $this->user->id]);

        $response = $this->getJson('/api/wishlist');

        $response->assertOk();
        $response->assertJsonFragment([
            'id' => $wishlist->id,
            'name' => 'Trip',
            'notes' => 'Overall trip note'
        ]);
    }

    public function test_store_creates_a_new_wishlist()
    {
        $country = Country::find(2);

        $data = [
            'name' => 'New Trip',
            'notes' => 'Trip notes',
            'countries' => [
                [
                    'country_id' => $country->id,
                    'start_date' => '2025-07-01',
                    'end_date' => '2025-07-10',
                    'notes' => 'Visit landmarks',
                ],
            ],
        ];

        $response = $this->postJson('/api/wishlist', $data);
        $response->assertCreated();

        $wishlistData = $response->json('data');

        $expected = [
            'id' => $wishlistData['id'],
            'user_id' => $this->user->id,
            'name' => 'New Trip',
            'notes' => 'Trip notes',
            'countries' => [
                [
                    'id' => $country->id,
                    'name' => $country->name,
                    'code' => $country->code,
                    'capital' => $country->capital,
                    'continent' => $country->continent,
                    'created_at' => $country->created_at->toJSON(),
                    'updated_at' => $country->updated_at->toJSON(),
                    'pivot' => [
                        'wishlist_id' => $wishlistData['id'],
                        'country_id' => $country->id,
                        'start_date' => '2025-07-01',
                        'end_date' => '2025-07-10',
                        'notes' => 'Visit landmarks',
                        'created_at' => $wishlistData['countries'][0]['pivot']['created_at'],
                        'updated_at' => $wishlistData['countries'][0]['pivot']['updated_at'],
                    ],
                ],
            ],
            'created_at' => $wishlistData['created_at'],
            'updated_at' => $wishlistData['updated_at'],
        ];

        $response->assertExactJson([
            'message' => 'Wishlist created successfully.',
            'data' => $expected,
        ]);

        $this->assertDatabaseHas('wishlists', [
            'id' => $wishlistData['id'],
            'user_id' => $this->user->id,
            'name' => 'New Trip',
            'notes' => 'Trip notes',
        ]);
        $this->assertDatabaseHas('wishlist_country', [
            'wishlist_id' => $wishlistData['id'],
            'country_id' => $country->id,
            'start_date' => '2025-07-01',
            'end_date' => '2025-07-10',
            'notes' => 'Visit landmarks',
        ]);
    }

    public function test_show_returns_specific_wishlist()
    {
        $country = Country::find(3);
        $wishlist = Wishlist::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'Solo Trip',
            'notes' => 'Solo trip note',
        ]);
        $wishlist->countries()->attach($country->id, [
            'start_date' => '2025-08-01',
            'end_date' => '2025-08-05',
            'notes' => 'Solo country note',
        ]);

        $response = $this->getJson("/api/wishlist/{$wishlist->id}");
        $data = $response->json('data');

        $expected = [
            'id' => $wishlist->id,
            'user_id' => $this->user->id,
            'name' => 'Solo Trip',
            'notes' => 'Solo trip note',
            'countries' => [
                [
                    'id' => $country->id,
                    'name' => $country->name,
                    'code' => $country->code,
                    'capital' => $country->capital,
                    'continent' => $country->continent,
                    'created_at' => $country->created_at->toJSON(),
                    'updated_at' => $country->updated_at->toJSON(),
                    'pivot' => [
                        'wishlist_id' => $wishlist->id,
                        'country_id' => $country->id,
                        'start_date' => '2025-08-01',
                        'end_date' => '2025-08-05',
                        'notes' => 'Solo country note',
                        'created_at' => $data['countries'][0]['pivot']['created_at'],
                        'updated_at' => $data['countries'][0]['pivot']['updated_at'],
                    ],
                ],
            ],
            'created_at' => $wishlist->created_at->toJSON(),
            'updated_at' => $wishlist->updated_at->toJSON(),
        ];

        $response->assertOk();
        $response->assertExactJson(['data' => $expected]);
    }

    public function test_update_modifies_a_wishlist()
    {
        $country1 = Country::find(4);
        $country2 = Country::find(5);
        $wishlist = Wishlist::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'Old Trip',
            'notes' => 'Old note',
        ]);
        $wishlist->countries()->attach($country1->id, [
            'start_date' => '2025-09-01',
            'end_date' => '2025-09-05',
            'notes' => 'Old country note',
        ]);

        $data = [
            'name' => 'Updated Trip',
            'notes' => 'Updated overall note',
            'countries' => [
                [
                    'country_id' => $country2->id,
                    'start_date' => '2025-10-01',
                    'end_date' => '2025-10-07',
                    'notes' => 'Updated country note',
                ],
            ],
        ];

        $response = $this->putJson("/api/wishlist/{$wishlist->id}", $data);
        $response->assertOk();

        $expected = [
            'id' => $wishlist->id,
            'user_id' => $this->user->id,
            'name' => 'Updated Trip',
            'notes' => 'Updated overall note',
            'countries' => [
                [
                    'id' => $country2->id,
                    'name' => $country2->name,
                    'code' => $country2->code,
                    'capital' => $country2->capital,
                    'continent' => $country2->continent,
                    'created_at' => $country2->created_at->toJSON(),
                    'updated_at' => $country2->updated_at->toJSON(),
                    'pivot' => [
                        'wishlist_id' => $wishlist->id,
                        'country_id' => $country2->id,
                        'start_date' => '2025-10-01',
                        'end_date' => '2025-10-07',
                        'notes' => 'Updated country note',
                        'created_at' => $response->json('data.countries')[0]['pivot']['created_at'],
                        'updated_at' => $response->json('data.countries')[0]['pivot']['updated_at'],
                    ],
                ],
            ],
            'created_at' => $wishlist->created_at->toJSON(),
            'updated_at' => $wishlist->updated_at->toJSON(),
        ];

        $response->assertExactJson([
            'message' => 'Wishlist updated successfully.',
            'data' => $expected,
        ]);
        $this->assertDatabaseHas('wishlists', [
            'id' => $wishlist->id,
            'name' => 'Updated Trip',
            'notes' => 'Updated overall note',
        ]);
        $this->assertDatabaseHas('wishlist_country', [
            'wishlist_id' => $wishlist->id,
            'country_id' => $country2->id,
            'start_date' => '2025-10-01',
            'end_date' => '2025-10-07',
            'notes' => 'Updated country note',
        ]);
    }

    public function test_destroy_deletes_a_wishlist()
    {
        $wishlist = Wishlist::factory()->create([
            'user_id' => $this->user->id,
            'name' => 'Trip',
            'notes' => 'Overall trip note'
        ]);
        $this->assertDatabaseHas('wishlists', [
            'id' => $wishlist->id,
            'name' => 'Trip',
            'notes' => 'Overall trip note'
        ]);

        $response = $this->deleteJson("/api/wishlist/{$wishlist->id}");

        $response->assertNoContent();
        $this->assertDatabaseMissing('wishlists', [
            'id' => $wishlist->id,
        ]);
    }
}
