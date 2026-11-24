<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Destination;
use App\Models\Hotel;
use App\Models\Tour;
use App\Models\TourCategory;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TourController extends Controller
{
    public function index(Request $request): View
    {
        $query = Tour::with(['manager', 'category', 'destination', 'hotels']);

        if (! in_array($request->user()?->role, ['manager', 'admin'])) {
            $query->where('status', 'published');
        }

        $tours = $query->orderBy('id', 'desc')->paginate(10);

        return view('tours.index', compact('tours'));
    }

    public function show(Request $request, string $id): View
    {
        $query = Tour::with([
            'manager',
            'category',
            'destination',
            'hotels',
            'itineraryDays',
        ]);

        if (! in_array($request->user()?->role, ['manager', 'admin'])) {
            $query->where('status', 'published');
        }

        $tour = $query->findOrFail($id);

        return view('tours.show', compact('tour'));
    }

    public function create(): View
    {
        $managers = User::where('role', 'manager')->get();
        $categories = TourCategory::orderBy('name')->get();
        $destinations = Destination::orderBy('country')->get();
        $hotels = Hotel::orderBy('name')->get();

        return view('tours.create', compact(
            'managers',
            'categories',
            'destinations',
            'hotels'
        ));
    }

    public function store(Request $request): RedirectResponse
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

        return redirect()->route('tours.index')
            ->with('success', 'Туристичну пропозицію успішно створено!');
    }

    public function edit(string $id): View
    {
        $tour = Tour::with('hotels')->findOrFail($id);

        $managers = User::where('role', 'manager')->get();
        $categories = TourCategory::orderBy('name')->get();
        $destinations = Destination::orderBy('country')->get();
        $hotels = Hotel::orderBy('name')->get();

        return view('tours.edit', compact(
            'tour',
            'managers',
            'categories',
            'destinations',
            'hotels'
        ));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $tour = Tour::findOrFail($id);

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

        $tour->update($validated);
        $tour->hotels()->sync($hotelIds);

        return redirect()->route('tours.index')
            ->with('success', 'Туристичну пропозицію успішно оновлено!');
    }

    public function destroy(string $id): RedirectResponse
    {
        $tour = Tour::findOrFail($id);
        $tour->delete();

        return redirect()->route('tours.index')
            ->with('success', 'Туристичну пропозицію успішно видалено!');
    }
}
