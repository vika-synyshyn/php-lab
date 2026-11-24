<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\TourDeparture;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless(
            in_array($request->user()?->role, ['customer', 'manager']),
            403
        );

        $query = Booking::with(['customer', 'departure']);

        if ($request->user()->role === 'customer') {
            $query->where('user_id', $request->user()->id);
        }

        $bookings = $query->orderBy('id', 'desc')->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function show(Request $request, string $id): View
    {
        abort_unless(
            in_array($request->user()?->role, ['customer', 'manager']),
            403
        );

        $booking = Booking::with([
            'customer',
            'departure',
            'travelers',
            'payments',
        ])->findOrFail($id);

        if ($request->user()->role === 'customer') {
            abort_unless(
                $booking->user_id == $request->user()->id,
                403
            );
        }

        return view('bookings.show', compact('booking'));
    }

    public function create(Request $request): View
    {
        abort_unless(
            in_array($request->user()?->role, ['customer', 'manager']),
            403
        );

        $users = User::where('role', 'customer')->get();

        $departures = TourDeparture::whereHas('tour', function ($query) {
            $query->where('status', 'published');
        })->get();

        return view('bookings.create', compact('users', 'departures'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless(
            in_array($request->user()?->role, ['customer', 'manager']),
            403
        );

        if ($request->user()->role === 'customer') {
            $request->merge([
                'user_id' => $request->user()->id,
            ]);
        }

        $validated = $request->validate([
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where('role', 'customer'),
            ],
            'tour_departure_id' => ['required', 'integer', 'exists:tour_departures,id'],
            'booking_code' => ['required', 'string', 'unique:bookings,booking_code'],
            'group_size' => ['required', 'integer', 'min:1'],
        ]);

        $departure = TourDeparture::whereHas('tour', function ($query) {
            $query->where('status', 'published');
        })->findOrFail($validated['tour_departure_id']);

        $validated['total_amount'] =
            $departure->price * $validated['group_size'];

        $validated['status'] = 'pending';

        Booking::create($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Бронювання успішно створено!');
    }

    public function edit(Request $request, string $id): View
    {
        abort_unless($request->user()?->role === 'manager', 403);

        $booking = Booking::findOrFail($id);
        $users = User::where('role', 'customer')->get();

        $departures = TourDeparture::whereHas('tour', function ($query) {
            $query->where('status', 'published');
        })->get();

        return view('bookings.edit', compact(
            'booking',
            'users',
            'departures'
        ));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        abort_unless($request->user()?->role === 'manager', 403);

        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'user_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where('role', 'customer'),
            ],
            'tour_departure_id' => ['required', 'integer', 'exists:tour_departures,id'],
            'booking_code' => [
                'required',
                'string',
                Rule::unique('bookings', 'booking_code')->ignore($booking->id),
            ],
            'group_size' => ['required', 'integer', 'min:1'],
        ]);

        $departure = TourDeparture::whereHas('tour', function ($query) {
            $query->where('status', 'published');
        })->findOrFail($validated['tour_departure_id']);

        $validated['total_amount'] =
            $departure->price * $validated['group_size'];

        $booking->update($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Бронювання успішно оновлено!');
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        abort_unless($request->user()?->role === 'manager', 403);

        $booking = Booking::findOrFail($id);

        if ($booking->payments()->exists() || $booking->travelers()->exists()) {
            return redirect()->route('bookings.index')
                ->with('error', 'Бронювання має пов’язані платежі або туристів.');
        }

        $booking->delete();

        return redirect()->route('bookings.index')
            ->with('success', 'Бронювання успішно видалено!');
    }
}
