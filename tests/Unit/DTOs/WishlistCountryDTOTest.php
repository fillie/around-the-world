<?php

namespace Tests\Unit\DTOs;

use App\DTOs\WishlistCountryDTO;
use App\Models\Country;
use Tests\TestCase;

class WishlistCountryDTOTest extends TestCase
{
    public function test_dto_properties_are_correctly_assigned()
    {
        $country = new Country();
        $dto = new WishlistCountryDTO(
            country: $country,
            startDate: '2025-04-01',
            endDate: '2025-04-10',
            notes: 'Test note'
        );

        $this->assertSame($country, $dto->country);
        $this->assertEquals('2025-04-01', $dto->startDate);
        $this->assertEquals('2025-04-10', $dto->endDate);
        $this->assertEquals('Test note', $dto->notes);
    }
}
