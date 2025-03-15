<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->country(),
            'code' => $this->faker->unique()->countryCode(),
            'capital' => $this->faker->text(20),
            'continent' => $this->faker->text(10),
        ];
    }

    public function resetUniqueFields(): void
    {
        $this->faker->unique(true);
    }
}
