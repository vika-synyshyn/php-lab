<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourDeparture;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TourDepartureController extends Controller
{
    public function index(): View
    {
        $departures = TourDeparture::with('tour')
            ->withCount('bookings')
            ->paginate(10);

        return view('departures.index', compact('departures'));
    }

    public function create(): View
    {
        $tours = Tour::all();

        return view('departures.create', compact('tours'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tour_id' => ['required', 'integer', 'exists:tours,id'],
            'departure_date' => ['required', 'date'],
            'capacity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'available_places' => ['required', 'integer', 'min:0', 'lte:capacity'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        TourDeparture::create($validated);

        return redirect()->route('departures.index')
            ->with('success', 'Виїзд успішно створено!');
    }

    public function edit(TourDeparture $departure): View
    {
        $tours = Tour::all();

        return view('departures.edit', compact('departure', 'tours'));
    }

    public function update(Request $request, TourDeparture $departure): RedirectResponse
    {
        $validated = $request->validate([
            'tour_id' => ['required', 'integer', 'exists:tours,id'],
            'departure_date' => ['required', 'date'],
            'capacity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'available_places' => ['required', 'integer', 'min:0', 'lte:capacity'],
            'status' => ['required', 'string', 'max:255'],
        ]);

        $departure->update($validated);

        return redirect()->route('departures.index')
            ->with('success', 'Виїзд успішно оновлено!');
    }

    public function destroy(TourDeparture $departure): RedirectResponse
    {
        if ($departure->bookings()->exists()) {
            return redirect()->route('departures.index')
                ->with('error', 'Виїзд містить пов’язані бронювання.');
        }

        $departure->delete();

        return redirect()->route('departures.index')
            ->with('success', 'Виїзд успішно видалено!');
    }
}
