<?php

namespace Tests\Unit\DTOs;

use App\DTOs\VisitDTO;
use App\Models\User;
use Tests\TestCase;

class VisitDTOTest extends TestCase
{
    public function test_dto_properties_are_correctly_assigned()
    {
        $user = User::factory()->make(['id' => 1]);
        $dto = new VisitDTO(
            user: $user,
            countryId: 2,
            dateVisited: '2025-03-28',
            lengthOfVisit: 10,
            notes: 'Sample notes'
        );

        $this->assertSame($user, $dto->user);
        $this->assertEquals(2, $dto->countryId);
        $this->assertEquals('2025-03-28', $dto->dateVisited);
        $this->assertEquals(10, $dto->lengthOfVisit);
        $this->assertEquals('Sample notes', $dto->notes);
    }
}
