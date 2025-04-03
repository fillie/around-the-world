<?php

namespace App\Repositories\Eloquent;

use App\Models\Country;
use App\Repositories\Contracts\CountryRepositoryInterface;

class EloquentCountryRepository implements CountryRepositoryInterface
{
    /**
     * @param int $id
     * @return Country|null
     */
    public function find(int $id): ?Country
    {
        return Country::find($id);
    }
}
