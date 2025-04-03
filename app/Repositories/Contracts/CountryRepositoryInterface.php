<?php

namespace App\Repositories\Contracts;

use App\Models\Country;

interface CountryRepositoryInterface
{
    /**
     * @param int $id
     * @return Country|null
     */
    public function find(int $id): ?Country;
}
