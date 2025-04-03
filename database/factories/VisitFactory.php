<?php

namespace Database\Factories;

use App\Models\Visit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'country_id' => 1,
            'date_visited' => $this->faker->date(),
            'length_of_visit' => $this->faker->numberBetween(1, 30),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
