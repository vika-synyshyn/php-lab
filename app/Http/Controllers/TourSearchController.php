<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TourSearchController extends Controller
{
    // GET /tours/search - пошук туристичних пропозицій
    public function search(Request $request): JsonResponse
    {
        $filters = $request->validate([
            'destination_id' => ['sometimes', 'integer', 'min:1'],
            'max_price' => ['sometimes', 'numeric', 'min:0'],
            'duration_days' => ['sometimes', 'integer', 'min:1'],
        ]);

        $query = Tour::with(['category', 'destination'])
            ->where('status', 'published');

        if (isset($filters['destination_id'])) {
            $query->where('destination_id', $filters['destination_id']);
        }

        if (isset($filters['max_price'])) {
            $query->where('base_price', '<=', $filters['max_price']);
        }

        if (isset($filters['duration_days'])) {
            $query->where('duration_days', $filters['duration_days']);
        }

        $tours = $query->get();

        return response()->json([
            'status' => 'success',
            'count' => $tours->count(),
            'filters' => $filters,
            'data' => $tours,
        ], 200);
    }
}
