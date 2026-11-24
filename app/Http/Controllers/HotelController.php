<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Hotel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HotelController extends Controller
{
    public function index(): View
    {
        $hotels = Hotel::with('destination')
            ->withCount('tours')
            ->paginate(10);

        return view('hotels.index', compact('hotels'));
    }

    public function create(): View
    {
        $destinations = Destination::all();

        return view('hotels.create', compact('destinations'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'stars' => ['required', 'integer', 'min:1', 'max:5'],
            'address' => ['required', 'string', 'max:255'],
            'destination_id' => ['required', 'integer', 'exists:destinations,id'],
        ]);

        Hotel::create($validated);

        return redirect()->route('hotels.index')
            ->with('success', 'Готель успішно створено!');
    }

    public function edit(Hotel $hotel): View
    {
        $destinations = Destination::all();

        return view('hotels.edit', compact('hotel', 'destinations'));
    }

    public function update(Request $request, Hotel $hotel): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'stars' => ['required', 'integer', 'min:1', 'max:5'],
            'address' => ['required', 'string', 'max:255'],
            'destination_id' => ['required', 'integer', 'exists:destinations,id'],
        ]);

        $hotel->update($validated);

        return redirect()->route('hotels.index')
            ->with('success', 'Готель успішно оновлено!');
    }

    public function destroy(Hotel $hotel): RedirectResponse
    {
        if ($hotel->tours()->exists()) {
            return redirect()->route('hotels.index')
                ->with('error', 'Готель пов’язаний із туристичними пропозиціями.');
        }

        $hotel->delete();

        return redirect()->route('hotels.index')
            ->with('success', 'Готель успішно видалено!');
    }
}
