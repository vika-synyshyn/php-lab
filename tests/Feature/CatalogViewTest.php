<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Tour;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogViewTest extends TestCase
{
    use RefreshDatabase;

    public function test_catalog_page_is_displayed(): void
    {
        Tour::factory()->create([
            'title' => 'Подорож до Карпат',
            'status' => 'published',
        ]);

        $response = $this->get(route('tours.index'));

        $response->assertStatus(200)
            ->assertViewIs('tours.index')
            ->assertSee('Каталог туристичних пропозицій')
            ->assertSee('Подорож до Карпат');
    }

    public function test_invalid_form_data_returns_validation_errors(): void
    {
        $manager = User::factory()->create([
            'role' => 'manager',
        ]);

        $response = $this->actingAs($manager)
            ->from(route('tours.create'))
            ->post(route('tours.store'), []);

        $response->assertRedirect(route('tours.create'))
            ->assertSessionHasErrors([
                'title',
                'manager_id',
                'category_id',
                'destination_id',
                'duration_days',
                'base_price',
            ]);
    }
}
