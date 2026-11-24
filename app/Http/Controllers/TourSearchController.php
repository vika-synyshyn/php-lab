<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TourSearchController extends Controller
{
    public function search(Request $request): View|JsonResponse
    {
        $filters = $request->validate([
            'destination_id' => ['nullable', 'integer', 'min:1'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
            'duration_days' => ['nullable', 'integer', 'min:1'],
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

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'count' => $tours->count(),
                'filters' => $filters,
                'data' => $tours,
            ], 200);
        }

        $destinations = Destination::orderBy('country')->get();

        return view('tours.search', compact(
            'tours',
            'destinations',
            'filters'
        ));
    }
}
