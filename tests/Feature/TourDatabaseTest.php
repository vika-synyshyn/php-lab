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

        Tour::factory()->create([
            'category_id' => $category->id,
            'title' => 'Подорож до Карпат',
            'status' => 'published',
        ]);

        $response = $this->get('/tours');

        $response->assertStatus(200)
            ->assertViewIs('tours.index')
            ->assertSee('Подорож до Карпат')
            ->assertSee('Екскурсійні');
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

        $response = $this->actingAs($manager)
            ->post('/tours', $payload);

        $response->assertRedirect(route('tours.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('tours', [
            'title' => 'Новий туристичний тур',
            'category_id' => $category->id,
            'status' => 'draft',
        ]);

        $tour = Tour::where('title', 'Новий туристичний тур')
            ->firstOrFail();

        foreach ($hotels as $hotel) {
            $this->assertDatabaseHas('tour_hotels', [
                'tour_id' => $tour->id,
                'hotel_id' => $hotel->id,
            ]);
        }
    }
}
