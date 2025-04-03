<?php

namespace Tests\Unit\Repositories\Eloquent;

use App\Models\Advice;
use App\Models\User;
use App\Repositories\Eloquent\EloquentAdviceRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;
use DateTime;

class EloquentAdviceRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_stores_advice_correctly()
    {
        $user = User::factory()->create();

        $repo = new EloquentAdviceRepository();
        $advice = $repo->create(
            $user,
            'France',
            new DateTime('2025-03-01'),
            new DateTime('2025-03-10'),
        );

        $this->assertDatabaseHas('advice', [
            'id' => $advice->id,
            'user_id' => $user->id,
            'country' => 'France',
            'start_date' => '2025-03-01 00:00:00',
            'end_date' => '2025-03-10 00:00:00',
        ]);
    }

    public function test_update_modifies_advice_content()
    {
        $advice = Advice::factory()->create([
            'content' => 'Original content',
        ]);

        $repo = new EloquentAdviceRepository();
        $repo->update($advice, 'Updated content');

        $this->assertDatabaseHas('advice', [
            'id' => $advice->id,
            'content' => 'Updated content',
        ]);
    }

    public function test_delete_removes_advice()
    {
        $advice = Advice::factory()->create();

        $repo = new EloquentAdviceRepository();
        $result = $repo->delete($advice);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('advice', ['id' => $advice->id]);
    }

    public function test_find_returns_advice_if_exists()
    {
        $advice = Advice::factory()->create();

        $repo = new EloquentAdviceRepository();
        $found = $repo->find($advice->id);

        $this->assertNotNull($found);
        $this->assertEquals($advice->id, $found->id);
    }

    public function test_find_returns_null_if_not_found()
    {
        $repo = new EloquentAdviceRepository();
        $this->assertNull($repo->find(999999));
    }

    public function test_all_returns_owned_scope()
    {
        $repo = new EloquentAdviceRepository();
        $result = $repo->all();

        $this->assertInstanceOf(Collection::class, $result);
    }
}
