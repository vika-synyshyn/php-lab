<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ItineraryDay;
use App\Models\Tour;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ItineraryDayController extends Controller
{
    public function index(): View
    {
        $days = ItineraryDay::with('tour')
            ->orderBy('tour_id')
            ->orderBy('day_number')
            ->paginate(10);

        return view('itinerary.index', compact('days'));
    }

    public function create(): View
    {
        $tours = Tour::all();

        return view('itinerary.create', compact('tours'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tour_id' => ['required', 'integer', 'exists:tours,id'],
            'day_number' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('itinerary_days', 'day_number')
                    ->where('tour_id', $request->input('tour_id')),
            ],
            'title' => ['required', 'string', 'max:255'],
            'activities' => ['required', 'string'],
        ]);

        ItineraryDay::create($validated);

        return redirect()->route('itinerary.index')
            ->with('success', 'День подорожі успішно створено!');
    }

    public function edit(ItineraryDay $day): View
    {
        $tours = Tour::all();

        return view('itinerary.edit', compact('day', 'tours'));
    }

    public function update(Request $request, ItineraryDay $day): RedirectResponse
    {
        $validated = $request->validate([
            'tour_id' => ['required', 'integer', 'exists:tours,id'],
            'day_number' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('itinerary_days', 'day_number')
                    ->where('tour_id', $request->input('tour_id'))
                    ->ignore($day->id),
            ],
            'title' => ['required', 'string', 'max:255'],
            'activities' => ['required', 'string'],
        ]);

        $day->update($validated);

        return redirect()->route('itinerary.index')
            ->with('success', 'День подорожі успішно оновлено!');
    }

    public function destroy(ItineraryDay $day): RedirectResponse
    {
        $day->delete();

        return redirect()->route('itinerary.index')
            ->with('success', 'День подорожі успішно видалено!');
    }
}
