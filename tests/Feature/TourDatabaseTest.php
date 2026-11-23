<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\Hotel;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TourDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_tours_with_relations(): void
    {
        $category = TourCategory::factory()->create([
            'name' => 'Екскурсійні',
        ]);

        $tour = Tour::factory()->create([
            'category_id' => $category->id,
            'title' => 'Подорож до Карпат',
        ]);

        $response = $this->getJson('/tours');

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Подорож до Карпат'])
            ->assertJsonFragment(['name' => 'Екскурсійні']);
    }

    public function test_can_create_tour_with_hotels_in_database(): void
    {
        $manager = User::factory()->create([
            'role' => 'manager',
        ]);

        $category = TourCategory::factory()->create();
        $destination = Destination::factory()->create();

        $hotels = Hotel::factory()->count(2)->create([
            'destination_id' => $destination->id,
        ]);

        $payload = [
            'title' => 'Новий туристичний тур',
            'manager_id' => $manager->id,
            'category_id' => $category->id,
            'destination_id' => $destination->id,
            'duration_days' => 5,
            'base_price' => 7500,
            'hotel_ids' => $hotels->pluck('id')->all(),
        ];

        $response = $this->withHeaders([
            'X-Tour-Role' => 'manager',
        ])->postJson('/tours', $payload);

        $response->assertStatus(201)
            ->assertJsonPath('status', 'created');

        $this->assertDatabaseHas('tours', [
            'title' => 'Новий туристичний тур',
            'category_id' => $category->id,
            'status' => 'draft',
        ]);

        $tourId = $response->json('data.id');

        foreach ($hotels as $hotel) {
            $this->assertDatabaseHas('tour_hotels', [
                'tour_id' => $tourId,
                'hotel_id' => $hotel->id,
            ]);
        }
    }
}
