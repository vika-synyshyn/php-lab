<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(): View
    {
        $payments = Payment::with('booking')->paginate(10);

        return view('payments.index', compact('payments'));
    }

    public function create(): View
    {
        $bookings = Booking::all();

        return view('payments.create', compact('bookings'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'booking_id' => ['required', 'integer', 'exists:bookings,id'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:99999999.99'],
            'method' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'paid_at' => ['nullable', 'date'],
        ]);

        Payment::create($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Платіж успішно створено!');
    }

    public function edit(Payment $payment): View
    {
        $bookings = Booking::all();

        return view('payments.edit', compact('payment', 'bookings'));
    }

    public function update(Request $request, Payment $payment): RedirectResponse
    {
        $validated = $request->validate([
            'booking_id' => ['required', 'integer', 'exists:bookings,id'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:99999999.99'],
            'method' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'paid_at' => ['nullable', 'date'],
        ]);

        $payment->update($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Платіж успішно оновлено!');
    }

    public function destroy(Payment $payment): RedirectResponse
    {
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', 'Платіж успішно видалено!');
    }
}
