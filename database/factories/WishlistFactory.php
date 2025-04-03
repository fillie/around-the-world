<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Database\Eloquent\Factories\Factory;

class WishlistFactory extends Factory
{
    protected $model = Wishlist::class;

    public function definition(): array {
        return [
            'user_id' => User::factory(),
            'name'  => $this->faker->words(3, true),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
