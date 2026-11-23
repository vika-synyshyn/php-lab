<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TourModerationController extends Controller
{
    // GET /tours/{id}/moderation
    public function index(Request $request, string $id): JsonResponse
    {
        if ($request->header('X-Tour-Role') !== 'admin') {
            return response()->json([
                'status' => 'access_denied',
            ], 403);
        }

        $tour = Tour::find($id);

        if (! $tour) {
            return response()->json([
                'status' => 'error',
                'message' => 'Тур не знайдено.',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $tour->moderationRecords()
                ->with('moderator')
                ->get(),
        ], 200);
    }

    // POST /tours/{id}/moderation
    public function store(Request $request, string $id): JsonResponse
    {
        if ($request->header('X-Tour-Role') !== 'admin') {
            return response()->json([
                'status' => 'access_denied',
            ], 403);
        }

        $validated = $request->validate([
            'moderator_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where('role', 'admin'),
            ],
            'decision' => ['required', Rule::in(['approved', 'rejected'])],
            'reason' => ['nullable', 'string'],
        ]);

        $tour = Tour::find($id);

        if (! $tour) {
            return response()->json([
                'status' => 'error',
                'message' => 'Тур не знайдено.',
            ], 404);
        }

        $record = DB::transaction(function () use ($tour, $validated) {
            $record = $tour->moderationRecords()->create($validated);

            $tour->update([
                'status' => $validated['decision'] === 'approved'
                    ? 'published'
                    : 'draft',
            ]);

            return $record;
        });

        return response()->json([
            'status' => 'created',
            'tour_status' => $tour->status,
            'data' => $record->load('moderator'),
        ], 201);
    }
}
