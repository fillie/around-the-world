<?php

namespace Tests\Unit\Repositories\Eloquent;

use App\Models\Country;
use App\Models\User;
use App\Models\Visit;
use App\Repositories\Eloquent\EloquentVisitRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Tests\TestCase;

class EloquentVisitRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_stores_data_correctly()
    {
        $user = User::factory()->create();
        $country = Country::find(1);

        $repo = new EloquentVisitRepository();
        $repo->create(
            $user->id,
            $country->id,
            '2025-03-28',
            5,
            'Notes'
        );

        $this->assertDatabaseHas('visits', [
            'user_id' => $user->id,
            'country_id' => $country->id,
            'date_visited' => '2025-03-28',
            'length_of_visit' => 5,
            'notes' => 'Notes',
        ]);
    }


    public function test_update_modifies_data_correctly()
    {
        $visit = Visit::factory()->create();
        $repo = new EloquentVisitRepository();

        $repo->update($visit, 99, '2025-04-01', 10, 'Updated note');

        $this->assertDatabaseHas('visits', [
            'id' => $visit->id,
            'country_id' => 99,
            'date_visited' => '2025-04-01',
            'length_of_visit' => 10,
            'notes' => 'Updated note',
        ]);
    }

    public function test_delete_removes_visit()
    {
        $visit = Visit::factory()->create();
        $repo = new EloquentVisitRepository();

        $result = $repo->delete($visit);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('visits', ['id' => $visit->id]);
    }

    public function test_all_returns_owned_scope()
    {
        $repo = new EloquentVisitRepository();
        $result = $repo->all();

        $this->assertInstanceOf(Collection::class, $result);
    }
}
