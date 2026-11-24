<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Destination;
use App\Models\TourCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TourAccessTest extends TestCase
{
    use RefreshDatabase;

    private function validTourData(): array
    {
        $manager = User::factory()->create([
            'role' => 'manager',
        ]);

        $category = TourCategory::create([
            'name' => 'Екскурсійні',
        ]);

        $destination = Destination::create([
            'country' => 'Франція',
            'region' => 'Іль-де-Франс',
            'city' => 'Париж',
        ]);

        return [
            'title' => 'Подорож до Парижа',
            'manager_id' => $manager->id,
            'category_id' => $category->id,
            'destination_id' => $destination->id,
            'duration_days' => 7,
            'base_price' => 18900,
        ];
    }

    // Неавтентифікований користувач не може створювати тури
    public function test_request_without_role_is_blocked(): void
    {
        $response = $this->post(
            '/tours',
            $this->validTourData()
        );

        $response->assertStatus(403);
    }

    // Клієнт не може створювати тури
    public function test_tourist_cannot_create_tour(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $response = $this->actingAs($customer)
            ->post('/tours', $this->validTourData());

        $response->assertStatus(403);
    }

    // Менеджер може створювати тури
    public function test_manager_can_create_tour(): void
    {
        $data = $this->validTourData();

        $manager = User::findOrFail($data['manager_id']);

        $response = $this->actingAs($manager)
            ->post('/tours', $data);

        $response->assertRedirect(route('tours.index'))
            ->assertSessionHas('success')
            ->assertHeader(
                'X-Security-Policy',
                'TourManagerVerified'
            );

        $this->assertDatabaseHas('tours', [
            'title' => 'Подорож до Парижа',
            'status' => 'draft',
        ]);
    }

    // Некоректні дані повинні відхилятися
    public function test_invalid_tour_data_is_rejected(): void
    {
        $data = $this->validTourData();

        $manager = User::findOrFail($data['manager_id']);

        $data['title'] = 'A';
        $data['duration_days'] = -5;
        $data['base_price'] = -100;

        $response = $this->actingAs($manager)
            ->from(route('tours.create'))
            ->post('/tours', $data);

        $response->assertRedirect(route('tours.create'))
            ->assertSessionHasErrors([
                'title',
                'duration_days',
                'base_price',
            ]);

        $this->assertDatabaseMissing('tours', [
            'title' => 'A',
        ]);
    }

    // Неіснуючий тур повертає 404
    public function test_nonexistent_tour_returns_404(): void
    {
        $response = $this->get('/tours/999');

        $response->assertStatus(404);
    }
}
