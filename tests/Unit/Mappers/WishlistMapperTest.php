<?php

namespace Tests\Unit\Mappers;

use App\DTOs\WishlistDTO;
use App\DTOs\WishlistCountryDTO;
use App\Mappers\WishlistMapper;
use App\Models\Country;
use App\Models\User;
use App\Repositories\Contracts\CountryRepositoryInterface;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;
use stdClass;

class WishlistMapperTest extends TestCase
{
    public function testMapRequestToWishlistDTO(): void
    {
        $countryId = 1;
        $dummyCountry = new Country();
        $dummyCountry->id = $countryId;
        $dummyCountry->name = 'Test Country';

        $dummyUser = new User();
        $dummyUser->id = 1;
        $dummyUser->name = 'Test User';
        $dummyUser->email = 'test@example.com';

        $countryRepositoryMock = $this->createMock(CountryRepositoryInterface::class);

        $countryRepositoryMock->method('find')
            ->willReturnCallback(function (int $id) use ($dummyCountry) {
                return $id === $dummyCountry->id ? $dummyCountry : null;
            });

        $mapper = new WishlistMapper($countryRepositoryMock);

        $request = new Request([
            'name' => 'Test Wishlist',
            'notes' => 'Some wishlist notes',
            'countries' => [
                [
                    'country_id' => $countryId,
                    'start_date' => '2023-01-01',
                    'end_date' => '2023-12-31',
                    'notes' => 'Country specific notes'
                ]
            ],
        ]);

        $request->setUserResolver(fn() => $dummyUser);

        $dto = $mapper->mapRequestToWishlistDTO($request);

        $this->assertInstanceOf(WishlistDTO::class, $dto);
        $this->assertSame($dummyUser, $dto->user);
        $this->assertSame('Test Wishlist', $dto->name);
        $this->assertSame('Some wishlist notes', $dto->notes);
        $this->assertCount(1, $dto->countries);

        $countryDTO = $dto->countries[0];
        $this->assertInstanceOf(WishlistCountryDTO::class, $countryDTO);
        $this->assertSame($dummyCountry, $countryDTO->country);
        $this->assertSame('2023-01-01', $countryDTO->startDate);
        $this->assertSame('2023-12-31', $countryDTO->endDate);
        $this->assertSame('Country specific notes', $countryDTO->notes);
    }
}
