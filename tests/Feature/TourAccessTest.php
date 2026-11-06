<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class TourAccessTest extends TestCase
{
    private function validTourData(): array
    {
        return [
            'title' => 'Подорож до Парижа',
            'manager_id' => 1,
            'category_id' => 2,
            'destination_id' => 4,
            'duration_days' => 7,
            'base_price' => 18900,
        ];
    }

    // Запит без ролі повинен блокуватися
    public function test_request_without_role_is_blocked(): void
    {
        $response = $this->postJson(
            '/tours',
            $this->validTourData()
        );

        $response->assertStatus(403)
            ->assertJson([
                'status' => 'access_denied',
            ]);
    }

    // Турист не може створювати тури
    public function test_tourist_cannot_create_tour(): void
    {
        $response = $this->withHeaders([
            'X-Tour-Role' => 'tourist',
        ])->postJson('/tours', $this->validTourData());

        $response->assertStatus(403);
    }

    // Менеджер може створювати тури
    public function test_manager_can_create_tour(): void
    {
        $response = $this->withHeaders([
            'X-Tour-Role' => 'manager',
        ])->postJson('/tours', $this->validTourData());

        $response->assertStatus(201)
            ->assertJsonPath('status', 'created')
            ->assertJsonPath('data.title', 'Подорож до Парижа')
            ->assertJsonPath('data.status', 'draft')
            ->assertHeader(
                'X-Security-Policy',
                'TourManagerVerified'
            );
    }

    // Некоректні дані повинні відхилятися
    public function test_invalid_tour_data_is_rejected(): void
    {
        $response = $this->withHeaders([
            'X-Tour-Role' => 'manager',
        ])->postJson('/tours', [
            'title' => 'A',
            'manager_id' => 1,
            'category_id' => 2,
            'destination_id' => 4,
            'duration_days' => -5,
            'base_price' => -100,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'title',
                'duration_days',
                'base_price',
            ]);
    }

    // Неіснуючий тур повертає 404
    public function test_nonexistent_tour_returns_404(): void
    {
        $response = $this->getJson('/tours/999');

        $response->assertStatus(404)
            ->assertJsonPath('status', 'error');
    }
}
