<?php

namespace Tests\Unit\Repositories\Eloquent;

use App\Models\Country;
use App\Repositories\Eloquent\EloquentCountryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentCountryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    // todo refactor when we sort countries
    public function test_find_returns_country_if_exists()
    {
        $country = Country::find(1);
        $repository = new EloquentCountryRepository();
        $foundCountry = $repository->find($country->id);
        $this->assertNotNull($foundCountry);
        $this->assertEquals($country->id, $foundCountry->id);
    }

    public function test_find_returns_null_if_country_does_not_exist()
    {
        $repository = new EloquentCountryRepository();
        $foundCountry = $repository->find(999999);
        $this->assertNull($foundCountry);
    }
}
