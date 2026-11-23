<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\Hotel;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'full_name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $manager = User::factory()->create([
            'role' => 'manager',
        ]);

        $categories = TourCategory::factory()->count(5)->create();

        foreach ($categories as $category) {
            $destination = Destination::factory()->create();

            $hotels = Hotel::factory()->count(2)->create([
                'destination_id' => $destination->id,
            ]);

            $tours = Tour::factory()->count(8)->create([
                'manager_id' => $manager->id,
                'category_id' => $category->id,
                'destination_id' => $destination->id,
            ]);

            foreach ($tours as $tour) {
                $tour->hotels()->sync($hotels->pluck('id')->all());
            }
        }
    }
}
