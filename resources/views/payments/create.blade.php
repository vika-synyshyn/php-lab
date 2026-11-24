@extends('layouts.app')

@section('title', 'Створення платежу')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Створення платежу</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('payments.store') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label">Бронювання</label>

                    <select name="booking_id"
                        class="form-select @error('booking_id') is-invalid @enderror">

                        <option value="">Оберіть бронювання</option>

                        @foreach ($bookings as $booking)
                            <option value="{{ $booking->id }}"
                                @selected(old('booking_id') == $booking->id)>
                                {{ $booking->booking_code }}
                            </option>
                        @endforeach
                    </select>

                    @error('booking_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <x-form.input name="amount" label="Сума платежу"
                    type="number" min="0.01" step="0.01" required />

                <x-form.input name="method"
                    label="Спосіб оплати" required />

                <x-form.input name="status"
                    label="Статус" value="pending" required />

                <x-form.input name="paid_at"
                    label="Дата та час оплати" type="datetime-local" />

                <button type="submit" class="btn btn-success">
                    Зберегти
                </button>

                <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection