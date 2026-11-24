@extends('layouts.app')

@section('title', 'Редагування туриста')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Редагування даних туриста</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('travelers.update', $traveler->id) }}"
                method="POST" novalidate>

                @csrf
                @method('PUT')

                <x-form.input name="first_name"
                    label="Ім'я туриста"
                    :value="$traveler->first_name" required />

                <x-form.input name="last_name"
                    label="Прізвище туриста"
                    :value="$traveler->last_name" required />

                <x-form.input name="birth_date"
                    label="Дата народження" type="date"
                    :value="$traveler->birth_date" required />

                <div class="mb-3">
                    <label class="form-label">Бронювання</label>

                    <select name="booking_id"
                        class="form-select @error('booking_id') is-invalid @enderror">

                        <option value="">Оберіть бронювання</option>

                        @foreach ($bookings as $booking)
                            <option value="{{ $booking->id }}"
                                @selected(old('booking_id', $traveler->booking_id) == $booking->id)>
                                {{ $booking->booking_code }}
                            </option>
                        @endforeach
                    </select>

                    @error('booking_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Оновити
                </button>

                <a href="{{ route('travelers.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection