<?php

namespace Database\Factories;

use App\Models\Destination;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tour>
 */
class TourFactory extends Factory
{
    public function definition(): array
    {
        return [
            'manager_id' => User::factory()->state([
                'role' => 'manager',
            ]),
            'category_id' => TourCategory::factory(),
            'destination_id' => Destination::factory(),
            'title' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'duration_days' => fake()->numberBetween(1, 14),
            'base_price' => fake()->randomFloat(2, 1000, 30000),
            'status' => 'draft',
        ];
    }
}
