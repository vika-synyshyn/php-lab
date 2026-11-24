<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Tour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TourModerationController extends Controller
{
    public function index(Request $request, string $id): View
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $tour = Tour::findOrFail($id);

        $records = $tour->moderationRecords()
            ->with('moderator')
            ->orderBy('id', 'desc')
            ->get();

        return view('moderation.index', compact('tour', 'records'));
    }

    public function create(Request $request, string $id): View
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $tour = Tour::findOrFail($id);

        return view('moderation.create', compact('tour'));
    }

    public function store(Request $request, string $id): RedirectResponse
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $validated = $request->validate([
            'decision' => ['required', Rule::in(['approved', 'rejected'])],
            'reason' => ['nullable', 'string'],
        ]);

        $tour = Tour::findOrFail($id);

        $validated['moderator_id'] = $request->user()->id;

        DB::transaction(function () use ($tour, $validated) {
            $tour->moderationRecords()->create($validated);

            $this->updateTourStatus($tour);
        });

        return redirect()->route('tours.moderation.index', $tour->id)
            ->with('success', 'Результат модерації успішно збережено!');
    }

    public function edit(Request $request, string $id, string $recordId): View
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $tour = Tour::findOrFail($id);

        $record = $tour->moderationRecords()->findOrFail($recordId);

        return view('moderation.edit', compact('tour', 'record'));
    }

    public function update(Request $request, string $id, string $recordId): RedirectResponse
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $tour = Tour::findOrFail($id);

        $record = $tour->moderationRecords()->findOrFail($recordId);

        $validated = $request->validate([
            'decision' => ['required', Rule::in(['approved', 'rejected'])],
            'reason' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($tour, $record, $validated) {
            $record->update($validated);

            $this->updateTourStatus($tour);
        });

        return redirect()->route('tours.moderation.index', $tour->id)
            ->with('success', 'Результат модерації успішно оновлено!');
    }

    public function destroy(Request $request, string $id, string $recordId): RedirectResponse
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $tour = Tour::findOrFail($id);

        $record = $tour->moderationRecords()->findOrFail($recordId);

        DB::transaction(function () use ($tour, $record) {
            $record->delete();

            $this->updateTourStatus($tour);
        });

        return redirect()->route('tours.moderation.index', $tour->id)
            ->with('success', 'Результат модерації успішно видалено!');
    }

    private function updateTourStatus(Tour $tour): void
    {
        $latestRecord = $tour->moderationRecords()
            ->orderBy('id', 'desc')
            ->first();

        $tour->update([
            'status' => $latestRecord?->decision === 'approved'
                ? 'published'
                : 'draft',
        ]);
    }
}
