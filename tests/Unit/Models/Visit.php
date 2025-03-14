<?php

namespace Tests\Unit\Models;

use App\Models\User;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VisitScopeTest extends TestCase
{
    use RefreshDatabase;

    public function testOwnedScopeReturnsOnlyUserVisits(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        Visit::factory()->count(3)->create(['user_id' => $user->id]);
        Visit::factory()->count(2)->create(['user_id' => $otherUser->id]);

        $this->actingAs($user);
        $ownedVisits = Visit::owned()->get();

        $this->assertCount(3, $ownedVisits);
        foreach ($ownedVisits as $visit) {
            $this->assertEquals($user->id, $visit->user_id);
        }
    }
}
