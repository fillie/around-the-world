<?php

namespace Tests\Unit\Services;

use App\DTOs\WishlistDTO;
use App\DTOs\WishlistCountryDTO;
use App\Models\Country;
use App\Models\User;
use App\Models\Wishlist;
use App\Repositories\Contracts\WishlistRepositoryInterface;
use App\Services\WishlistService;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class WishlistServiceTest extends TestCase
{
    public function test_create_wishlist_calls_repository_with_correct_data(): void
    {
        $user = User::factory()->make(['id' => 1]);
        $dummyCountry = new Country();
        $dummyCountry->id = 1;

        $wishlistCountryDTO = new WishlistCountryDTO(
            country: $dummyCountry,
            startDate: '2025-01-01',
            endDate: '2025-01-10',
            notes: 'Test country note'
        );

        $dto = new WishlistDTO(
            user: $user,
            name: 'Test Wishlist',
            notes: 'Some wishlist notes',
            countries: [$wishlistCountryDTO]
        );

        $expectedMapping = [
            [
                'country_id' => $dummyCountry->id,
                'start_date' => '2025-01-01',
                'end_date' => '2025-01-10',
                'notes' => 'Test country note',
            ],
        ];

        $mockRepo = Mockery::mock(WishlistRepositoryInterface::class);
        $mockRepo->shouldReceive('create')
            ->once()
            ->with($user, 'Test Wishlist', 'Some wishlist notes', $expectedMapping)
            ->andReturn(new Wishlist());

        $service = new WishlistService($mockRepo);
        $result = $service->createWishlist($dto);

        $this->assertInstanceOf(Wishlist::class, $result);
    }

    public function test_update_wishlist_calls_repository_with_correct_data(): void
    {
        $wishlist = Mockery::mock(Wishlist::class);
        $user = User::factory()->make();
        $dummyCountry = new Country();
        $dummyCountry->id = 2;

        $wishlistCountryDTO = new WishlistCountryDTO(
            country: $dummyCountry,
            startDate: '2025-02-01',
            endDate: '2025-02-10',
            notes: 'Updated country note'
        );

        $dto = new WishlistDTO(
            user: $user,
            name: 'Updated Wishlist',
            notes: 'Updated wishlist notes',
            countries: [$wishlistCountryDTO]
        );

        $expectedMapping = [
            [
                'country_id' => $dummyCountry->id,
                'start_date' => '2025-02-01',
                'end_date' => '2025-02-10',
                'notes' => 'Updated country note',
            ],
        ];

        $mockRepo = Mockery::mock(WishlistRepositoryInterface::class);
        $mockRepo->shouldReceive('update')
            ->once()
            ->with($wishlist, 'Updated Wishlist', 'Updated wishlist notes', $expectedMapping)
            ->andReturn($wishlist);

        $service = new WishlistService($mockRepo);
        $result = $service->updateWishlist($wishlist, $dto);

        $this->assertSame($wishlist, $result);
    }

    public function test_delete_wishlist_calls_repository(): void
    {
        $wishlist = Mockery::mock(Wishlist::class);

        $mockRepo = Mockery::mock(WishlistRepositoryInterface::class);
        $mockRepo->shouldReceive('delete')
            ->once()
            ->with($wishlist)
            ->andReturn(true);

        $service = new WishlistService($mockRepo);
        $result = $service->deleteWishlist($wishlist);

        $this->assertTrue($result);
    }

    public function test_get_all_wishlists_returns_collection(): void
    {
        $collection = new Collection();
        $mockRepo = Mockery::mock(WishlistRepositoryInterface::class);
        $mockRepo->shouldReceive('all')
            ->once()
            ->andReturn($collection);

        $service = new WishlistService($mockRepo);
        $result = $service->getAllWishlists();

        $this->assertInstanceOf(Collection::class, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
