<?php

namespace Tests\Unit\DTOs;

use App\DTOs\WishlistDTO;
use App\DTOs\WishlistCountryDTO;
use App\Models\Country;
use App\Models\User;
use Tests\TestCase;

class WishlistDTOTest extends TestCase
{
    public function test_dto_properties_are_correctly_assigned()
    {
        $user = new User();
        $country = new Country();
        $wishlistCountryDTO = new WishlistCountryDTO(
            country: $country,
            startDate: '2025-05-01',
            endDate: '2025-05-10',
            notes: 'Note'
        );
        $dto = new WishlistDTO(
            user: $user,
            name: 'My Wishlist',
            notes: 'Wishlist notes',
            countries: [$wishlistCountryDTO]
        );

        $this->assertSame($user, $dto->user);
        $this->assertEquals('My Wishlist', $dto->name);
        $this->assertEquals('Wishlist notes', $dto->notes);
        $this->assertCount(1, $dto->countries);
        $this->assertInstanceOf(WishlistCountryDTO::class, $dto->countries[0]);
    }
}
