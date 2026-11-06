<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TourSearchController extends Controller
{
    // Демонстраційні туристичні пропозиції
    private array $tours = [
        [
            'id' => 1,
            'title' => 'Відпочинок у Карпатах',
            'destination_id' => 1,
            'duration_days' => 5,
            'base_price' => 8500.00,
            'status' => 'published',
        ],
        [
            'id' => 2,
            'title' => 'Подорож до Італії',
            'destination_id' => 2,
            'duration_days' => 7,
            'base_price' => 25000.00,
            'status' => 'published',
        ],
        [
            'id' => 3,
            'title' => 'Альпійський вікенд',
            'destination_id' => 3,
            'duration_days' => 3,
            'base_price' => 12000.00,
            'status' => 'draft',
        ],
    ];

    // GET /tours/search - пошук туристичних пропозицій
    public function search(Request $request): JsonResponse
    {
        $filters = $request->validate([
            'destination_id' => ['sometimes', 'integer', 'min:1'],
            'max_price' => ['sometimes', 'numeric', 'min:0'],
            'duration_days' => ['sometimes', 'integer', 'min:1'],
        ]);

        $result = array_filter(
            $this->tours,
            function (array $tour) use ($filters): bool {
                // Публічний пошук лише серед опублікованих турів
                if ($tour['status'] !== 'published') {
                    return false;
                }

                if (
                    isset($filters['destination_id']) &&
                    $tour['destination_id'] !== (int) $filters['destination_id']
                ) {
                    return false;
                }

                if (
                    isset($filters['max_price']) &&
                    $tour['base_price'] > (float) $filters['max_price']
                ) {
                    return false;
                }

                if (
                    isset($filters['duration_days']) &&
                    $tour['duration_days'] !== (int) $filters['duration_days']
                ) {
                    return false;
                }

                return true;
            }
        );

        return response()->json([
            'status' => 'success',
            'count' => count($result),
            'filters' => $filters,
            'data' => array_values($result),
        ], 200);
    }
}
