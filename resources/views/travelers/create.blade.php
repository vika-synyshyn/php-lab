@extends('layouts.app')

@section('title', 'Додавання туриста')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Додавання туриста</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('travelers.store') }}" method="POST" novalidate>
                @csrf

                <x-form.input name="first_name"
                    label="Ім'я туриста" required />

                <x-form.input name="last_name"
                    label="Прізвище туриста" required />

                <x-form.input name="birth_date"
                    label="Дата народження" type="date" required />

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

                <button type="submit" class="btn btn-success">
                    Зберегти
                </button>

                <a href="{{ route('travelers.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection