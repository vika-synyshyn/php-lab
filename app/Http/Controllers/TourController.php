<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TourController extends Controller
{
    // Тимчасове сховище туристичних пропозицій
    private array $tours = [
        [
            'id' => 1,
            'title' => 'Відпочинок у Карпатах',
            'manager_id' => 1,
            'category_id' => 1,
            'destination_id' => 1,
            'duration_days' => 5,
            'base_price' => 8500.00,
            'status' => 'published',
        ],
        [
            'id' => 2,
            'title' => 'Подорож до Італії',
            'manager_id' => 1,
            'category_id' => 2,
            'destination_id' => 2,
            'duration_days' => 7,
            'base_price' => 25000.00,
            'status' => 'published',
        ],
        [
            'id' => 3,
            'title' => 'Альпійський вікенд',
            'manager_id' => 2,
            'category_id' => 3,
            'destination_id' => 3,
            'duration_days' => 3,
            'base_price' => 12000.00,
            'status' => 'draft',
        ],
    ];

    // GET /tours - отримання всіх турів
    public function index(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'count' => count($this->tours),
            'data' => $this->tours,
        ], 200);
    }

    // GET /tours/{id} - перегляд конкретного туру
    public function show(string $id): JsonResponse
    {
        foreach ($this->tours as $tour) {
            if ($tour['id'] === (int) $id) {
                return response()->json([
                    'status' => 'success',
                    'data' => $tour,
                ], 200);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Тур із зазначеним ID не знайдено.',
        ], 404);
    }

    // POST /tours - створення нового туру
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'manager_id' => ['required', 'integer', 'min:1'],
            'category_id' => ['required', 'integer', 'min:1'],
            'destination_id' => ['required', 'integer', 'min:1'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'base_price' => ['required', 'numeric', 'min:0'],
        ]);

        $newTour = [
            'id' => max(array_column($this->tours, 'id')) + 1,
            'title' => $validated['title'],
            'manager_id' => $validated['manager_id'],
            'category_id' => $validated['category_id'],
            'destination_id' => $validated['destination_id'],
            'duration_days' => $validated['duration_days'],
            'base_price' => (float) $validated['base_price'],
            'status' => 'draft',
        ];

        return response()->json([
            'status' => 'created',
            'message' => 'Туристичну пропозицію успішно сформовано.',
            'data' => $newTour,
        ], 201);
    }
}
