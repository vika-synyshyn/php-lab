<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TourController extends Controller
{
    // GET /tours
    public function index(): JsonResponse
    {
        $tours = Tour::with(['manager', 'category', 'destination'])->get();

        return response()->json([
            'status' => 'success',
            'count' => $tours->count(),
            'data' => $tours,
        ], 200);
    }

    // GET /tours/{id}
    public function show(string $id): JsonResponse
    {
        $tour = Tour::with([
            'manager',
            'category',
            'destination',
            'hotels',
            'itineraryDays',
        ])->find($id);

        if (! $tour) {
            return response()->json([
                'status' => 'error',
                'message' => 'Тур із зазначеним ID не знайдено.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $tour,
        ], 200);
    }

    // POST /tours
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'manager_id' => ['required', 'integer', 'exists:users,id'],
            'category_id' => ['required', 'integer', 'exists:tour_categories,id'],
            'destination_id' => ['required', 'integer', 'exists:destinations,id'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'hotel_ids' => ['sometimes', 'array'],
            'hotel_ids.*' => ['integer', 'distinct', 'exists:hotels,id'],
        ]);

        $hotelIds = $validated['hotel_ids'] ?? [];
        unset($validated['hotel_ids']);

        $validated['status'] = 'draft';

        $newTour = Tour::create($validated);

        $newTour->hotels()->sync($hotelIds);

        $newTour->load(['category', 'destination', 'hotels']);

        return response()->json([
            'status' => 'created',
            'message' => 'Туристичну пропозицію успішно сформовано.',
            'data' => $newTour,
        ], 201);
    }
}
