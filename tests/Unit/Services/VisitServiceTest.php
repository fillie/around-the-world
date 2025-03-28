<?php

namespace Tests\Unit\Services;

use App\DTOs\VisitDTO;
use App\Models\User;
use App\Models\Visit;
use App\Services\VisitService;
use App\Repositories\Contracts\VisitRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class VisitServiceTest extends TestCase
{
    public function test_create_visit_calls_repository_with_correct_data()
    {
        $user = User::factory()->make(['id' => 1]);
        $dto = new VisitDTO(
            user: $user,
            countryId: 10,
            dateVisited: '2025-03-28',
            lengthOfVisit: 5,
            notes: 'Trip note'
        );

        $mockRepo = Mockery::mock(VisitRepositoryInterface::class);
        $mockRepo->shouldReceive('create')
            ->once()
            ->with(1, 10, '2025-03-28', 5, 'Trip note')
            ->andReturn(new Visit());

        $service = new VisitService($mockRepo);
        $result = $service->createVisit($dto);

        $this->assertInstanceOf(Visit::class, $result);
    }

    public function test_update_visit_calls_repository_with_correct_data()
    {
        $visit = Mockery::mock(Visit::class);
        $dto = new VisitDTO(
            user: User::factory()->make(),
            countryId: 2,
            dateVisited: '2025-03-28',
            lengthOfVisit: 3,
            notes: 'Updated note'
        );

        $mockRepo = Mockery::mock(VisitRepositoryInterface::class);
        $mockRepo->shouldReceive('update')
            ->once()
            ->with($visit, 2, '2025-03-28', 3, 'Updated note')
            ->andReturn($visit);

        $service = new VisitService($mockRepo);
        $result = $service->updateVisit($visit, $dto);

        $this->assertSame($visit, $result);
    }

    public function test_delete_visit_calls_repository()
    {
        $visit = Mockery::mock(Visit::class);

        $mockRepo = Mockery::mock(VisitRepositoryInterface::class);
        $mockRepo->shouldReceive('delete')
            ->once()
            ->with($visit)
            ->andReturn(true);

        $service = new VisitService($mockRepo);
        $result = $service->deleteVisit($visit);

        $this->assertTrue($result);
    }

    public function test_get_all_visits_returns_collection()
    {
        $mockRepo = Mockery::mock(VisitRepositoryInterface::class);
        $mockRepo->shouldReceive('all')
            ->once()
            ->andReturn(new Collection());

        $service = new VisitService($mockRepo);
        $result = $service->getAllVisits();

        $this->assertInstanceOf(Collection::class, $result);
    }
}
