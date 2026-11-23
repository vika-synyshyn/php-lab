<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    // GET /bookings
    public function index(): JsonResponse
    {
        $bookings = Booking::with(['customer', 'departure'])->get();

        return response()->json([
            'status' => 'success',
            'count' => $bookings->count(),
            'data' => $bookings,
        ], 200);
    }

    // GET /bookings/{id}
    public function show(string $id): JsonResponse
    {
        $booking = Booking::with([
            'customer',
            'departure',
            'travelers',
            'payments',
        ])->find($id);

        if (! $booking) {
            return response()->json([
                'status' => 'error',
                'message' => 'Бронювання не знайдено.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $booking,
        ], 200);
    }

    // POST /bookings
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'tour_departure_id' => ['required', 'integer', 'exists:tour_departures,id'],
            'booking_code' => ['required', 'string', 'unique:bookings,booking_code'],
            'group_size' => ['required', 'integer', 'min:1'],
            'total_amount' => ['required', 'numeric', 'min:0'],
        ]);

        $validated['status'] = 'pending';

        $booking = Booking::create($validated);

        return response()->json([
            'status' => 'created',
            'data' => $booking,
        ], 201);
    }
}
