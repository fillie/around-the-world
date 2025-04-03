<?php

namespace Tests\Unit\Models;

use App\Models\Advice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdviceScopeTest extends TestCase
{
    use RefreshDatabase;

    public function testOwnedScopeReturnsOnlyUserVisits(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        Advice::factory()->count(3)->create(['user_id' => $user->id]);
        Advice::factory()->count(2)->create(['user_id' => $otherUser->id]);

        $this->actingAs($user);
        $ownedAdvice = Advice::owned()->get();

        $this->assertCount(3, $ownedAdvice);
        foreach ($ownedAdvice as $advice) {
            $this->assertEquals($user->id, $advice->user_id);
        }
    }
}
