<?php

namespace Tests\Unit\Services;

use App\DTOs\VisitDTO;
use App\Models\Visit;
use App\Models\User;
use App\Services\VisitService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitServiceTest extends TestCase
{
    use RefreshDatabase;

    protected VisitService $visitService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->visitService = new VisitService();
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function testCreateVisit(): void
    {
        $dto = new VisitDTO(
            country_id: 1,
            date_visited: '2025-03-14',
            length_of_visit: 7,
            notes: 'Test visit'
        );

        $visit = $this->visitService->createVisit($dto);

        $this->assertDatabaseHas('visits', [
            'id'             => $visit->id,
            'user_id'        => Auth::id(),
            'country_id'     => 1,
            'date_visited'   => '2025-03-14',
            'length_of_visit'=> 7,
            'notes'          => 'Test visit'
        ]);
    }

    public function testUpdateVisit(): void
    {
        $visit = Visit::factory()->create([
            'user_id'        => Auth::id(),
            'country_id'     => 1,
            'date_visited'   => '2025-03-14',
            'length_of_visit'=> 7,
            'notes'          => 'Old note'
        ]);

        $dto = new VisitDTO(
            country_id: 2,
            date_visited: '2025-03-15',
            length_of_visit: 10,
            notes: 'Updated note'
        );

        $updatedVisit = $this->visitService->updateVisit($visit, $dto);

        $this->assertEquals(2, $updatedVisit->country_id);
        $this->assertEquals('2025-03-15', $updatedVisit->date_visited);
        $this->assertEquals(10, $updatedVisit->length_of_visit);
        $this->assertEquals('Updated note', $updatedVisit->notes);
    }
}
