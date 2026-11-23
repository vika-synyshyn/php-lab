<?php

namespace Database\Factories;

use App\Models\Destination;
use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Hotel>
 */
class HotelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'destination_id' => Destination::factory(),
            'name' => ucfirst(fake()->words(2, true)),
            'stars' => fake()->numberBetween(1, 5),
            'address' => fake()->address(),
        ];
    }
}
