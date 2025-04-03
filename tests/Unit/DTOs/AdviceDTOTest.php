<?php

namespace Tests\Unit\DTOs;

use App\DTOs\AdviceRequestDTO;
use Tests\TestCase;

class AdviceDTOTest extends TestCase
{
    public function test_dto_properties_are_correctly_assigned()
    {
        $dto = new AdviceRequestDTO(
            countries: [
                'United States',
            ],
            startDate: '2025-04-01',
            endDate: '2025-05-01',
        );

        $this->assertEquals([
            'United States',
        ], $dto->countries);
        $this->assertEquals('2025-04-01', $dto->startDate);
        $this->assertEquals('2025-05-01', $dto->endDate);
    }
}
