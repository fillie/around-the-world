<?php

namespace App\DTOs;

final class CountryDTO
{
    /**
     * @param string $name
     * @param string $code
     * @param string $capital
     * @param string $continent
     */
    public function __construct(
        public string $name,
        public string $code,
        public string $capital,
        public string $continent,
    ){}
}
