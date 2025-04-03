<?php

namespace Database\Factories;

use App\Models\Advice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdviceFactory extends Factory
{
    protected $model = Advice::class;

    /**
     * @throws \DateMalformedStringException
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 year');
        $endDate = (clone $startDate)->modify('+5 days');

        return [
            'user_id' => User::factory(),
            'country' => $this->faker->country,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'content' => $this->faker->paragraph,
        ];
    }
}
