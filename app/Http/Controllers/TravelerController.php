<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Traveler;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TravelerController extends Controller
{
    public function index(): View
    {
        $travelers = Traveler::with('booking')->paginate(10);

        return view('travelers.index', compact('travelers'));
    }

    public function create(): View
    {
        $bookings = Booking::all();

        return view('travelers.create', compact('bookings'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'booking_id' => ['required', 'integer', 'exists:bookings,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
        ]);

        Traveler::create($validated);

        return redirect()->route('travelers.index')
            ->with('success', 'Туриста успішно додано!');
    }

    public function edit(Traveler $traveler): View
    {
        $bookings = Booking::all();

        return view('travelers.edit', compact('traveler', 'bookings'));
    }

    public function update(Request $request, Traveler $traveler): RedirectResponse
    {
        $validated = $request->validate([
            'booking_id' => ['required', 'integer', 'exists:bookings,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birth_date' => ['required', 'date', 'before_or_equal:today'],
        ]);

        $traveler->update($validated);

        return redirect()->route('travelers.index')
            ->with('success', 'Дані туриста успішно оновлено!');
    }

    public function destroy(Traveler $traveler): RedirectResponse
    {
        $traveler->delete();

        return redirect()->route('travelers.index')
            ->with('success', 'Туриста успішно видалено!');
    }
}
