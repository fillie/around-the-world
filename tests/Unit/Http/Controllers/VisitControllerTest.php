<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'api');
    }

    public function testIndexReturnsUserVisits(): void
    {
        Visit::factory()->count(3)->create(['user_id' => $this->user->id]);
        Visit::factory()->create();

        $response = $this->getJson('/api/visits');
        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function testStoreCreatesVisit(): void
    {
        $data = [
            'country_id' => 1,
            'date_visited' => '2025-03-14',
            'length_of_visit' => 5,
            'notes' => 'New visit'
        ];

        $response = $this->postJson('/api/visits', $data);
        $response->assertStatus(201)
            ->assertJsonFragment(['notes' => 'New visit']);

        $this->assertDatabaseHas('visits', [
            'user_id'        => $this->user->id,
            'country_id'     => 1,
            'date_visited'   => '2025-03-14',
            'length_of_visit'=> 5,
            'notes'          => 'New visit'
        ]);
    }

    public function testShowReturnsVisit(): void
    {
        $visit = Visit::factory()->create(['user_id' => $this->user->id]);
        $response = $this->getJson('/api/visits/' . $visit->id);
        $response->assertStatus(200)
            ->assertJsonFragment(['id' => $visit->id]);
    }

    public function testUpdateModifiesVisit(): void
    {
        $visit = Visit::factory()->create(['user_id' => $this->user->id]);
        $data = [
            'country_id' => 2,
            'date_visited' => '2025-03-15',
            'length_of_visit' => 10,
            'notes' => 'Updated visit'
        ];

        $response = $this->putJson('/api/visits/' . $visit->id, $data);
        $response->assertStatus(200)
            ->assertJsonFragment(['notes' => 'Updated visit']);

        $this->assertDatabaseHas('visits', [
            'id'             => $visit->id,
            'country_id'     => 2,
            'date_visited'   => '2025-03-15',
            'length_of_visit'=> 10,
            'notes'          => 'Updated visit'
        ]);
    }

    public function testDestroyDeletesVisit(): void
    {
        $visit = Visit::factory()->create(['user_id' => $this->user->id]);
        $response = $this->deleteJson('/api/visits/' . $visit->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('visits', ['id' => $visit->id]);
    }
}
