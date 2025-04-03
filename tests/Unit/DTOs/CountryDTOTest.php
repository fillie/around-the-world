<?php

namespace Tests\Unit\DTOs;

use App\DTOs\CountryDTO;
use Tests\TestCase;

class CountryDTOTest extends TestCase
{
    public function test_dto_properties_are_correctly_assigned()
    {
        $dto = new CountryDTO(
            name: 'Test Country',
            code: 'TC',
            capital: 'Test Capital',
            continent: 'Test Continent'
        );

        $this->assertEquals('Test Country', $dto->name);
        $this->assertEquals('TC', $dto->code);
        $this->assertEquals('Test Capital', $dto->capital);
        $this->assertEquals('Test Continent', $dto->continent);
    }
}
