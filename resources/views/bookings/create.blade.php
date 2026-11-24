@extends('layouts.app')

@section('title', 'Створення бронювання')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Створення бронювання</h2>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    Виправте помилки у формі.
                </div>
            @endif

            <form action="{{ route('bookings.store') }}" method="POST" novalidate>
                @csrf

                <x-form.input name="booking_code"
                    label="Код бронювання" required />

                <x-form.input name="group_size"
                    label="Кількість туристів"
                    type="number" min="1" required />

                @if (auth()->user()?->role === 'manager')
                    <div class="mb-3">
                        <label class="form-label">Клієнт</label>

                        <select name="user_id"
                            class="form-select @error('user_id') is-invalid @enderror">

                            <option value="">Оберіть клієнта</option>

                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    @selected(old('user_id') == $user->id)>
                                    {{ $user->full_name }}
                                </option>
                            @endforeach
                        </select>

                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @else
                    <p>
                        <strong>Клієнт:</strong>
                        {{ auth()->user()->full_name }}
                    </p>
                @endif

                <div class="mb-3">
                    <label class="form-label">Туристичний виїзд</label>

                    <select name="tour_departure_id"
                        class="form-select @error('tour_departure_id') is-invalid @enderror">

                        <option value="">Оберіть виїзд</option>

                        @foreach ($departures as $departure)
                            <option value="{{ $departure->id }}"
                                @selected(old('tour_departure_id') == $departure->id)>
                                Виїзд #{{ $departure->id }} — {{ $departure->price }} грн
                            </option>
                        @endforeach
                    </select>

                    @error('tour_departure_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <p class="text-muted">
                    Загальна сума розраховується автоматично.
                </p>

                <button type="submit" class="btn btn-success">
                    Зберегти
                </button>

                <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection