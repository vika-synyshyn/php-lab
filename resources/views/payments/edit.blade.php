@extends('layouts.app')

@section('title', 'Редагування платежу')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Редагування платежу</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('payments.update', $payment->id) }}"
                method="POST" novalidate>

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Бронювання</label>

                    <select name="booking_id"
                        class="form-select @error('booking_id') is-invalid @enderror">

                        <option value="">Оберіть бронювання</option>

                        @foreach ($bookings as $booking)
                            <option value="{{ $booking->id }}"
                                @selected(old('booking_id', $payment->booking_id) == $booking->id)>
                                {{ $booking->booking_code }}
                            </option>
                        @endforeach
                    </select>

                    @error('booking_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <x-form.input name="amount" label="Сума платежу"
                    type="number" min="0.01" step="0.01"
                    :value="$payment->amount" required />

                <x-form.input name="method"
                    label="Спосіб оплати"
                    :value="$payment->method" required />

                <x-form.input name="status"
                    label="Статус"
                    :value="$payment->status" required />

                <x-form.input name="paid_at"
                    label="Дата та час оплати" type="datetime-local"
                    :value="$payment->paid_at ? \Illuminate\Support\Carbon::parse($payment->paid_at)->format('Y-m-d\TH:i') : ''" />

                <button type="submit" class="btn btn-primary">
                    Оновити
                </button>

                <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection