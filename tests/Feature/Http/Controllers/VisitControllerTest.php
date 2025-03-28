<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Country;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }

    public function test_index_returns_all_visits()
    {
        Visit::factory()->count(3)->create();

        $response = $this->getJson('/api/visit');

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'country_id',
                    'date_visited',
                    'length_of_visit',
                    'notes',
                    'created_at',
                    'updated_at'
                ]
            ]
        ]);
    }

    public function test_store_creates_a_new_visit()
    {
        $country = Country::first();

        $data = [
            'country_id' => $country->id,
            'date_visited' => now()->toDateString(),
            'length_of_visit' => 7,
            'notes' => 'Test visit'
        ];

        $response = $this->postJson('/api/visit', $data);

        $response->assertCreated();
        $response->assertJsonFragment([
            'message' => 'Visit recorded successfully.'
        ]);
        $this->assertDatabaseHas('visits', [
            'country_id' => $data['country_id'],
            'notes' => 'Test visit'
        ]);
    }


    public function test_show_returns_specific_visit()
    {
        $visit = Visit::factory()->create();

        $response = $this->getJson("/api/visit/{$visit->id}");

        $response->assertOk();
        $response->assertJsonFragment([
            'id' => $visit->id
        ]);
    }

    public function test_update_modifies_a_visit()
    {
        $visit = Visit::factory()->create();
        $newCountry = Country::where('id', '!=', $visit->country_id)->first();

        $data = [
            'country_id' => $newCountry->id,
            'date_visited' => now()->subDays(3)->toDateString(),
            'length_of_visit' => 10,
            'notes' => 'Updated note'
        ];

        $response = $this->putJson("/api/visit/{$visit->id}", $data);

        $response->assertOk();
        $response->assertJsonFragment([
            'message' => 'Visit updated successfully.'
        ]);
        $this->assertDatabaseHas('visits', [
            'id' => $visit->id,
            'country_id' => $data['country_id'],
            'notes' => 'Updated note'
        ]);
    }


    public function test_destroy_deletes_a_visit()
    {
        $visit = Visit::factory()->create();

        $response = $this->deleteJson("/api/visit/{$visit->id}");

        $response->assertNoContent();
        $this->assertDatabaseMissing('visits', [
            'id' => $visit->id
        ]);
    }
}
