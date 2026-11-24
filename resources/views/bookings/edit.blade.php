@extends('layouts.app')

@section('title', 'Редагування бронювання')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Редагування бронювання #{{ $booking->id }}</h2>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    Виправте помилки у формі.
                </div>
            @endif

            <form action="{{ route('bookings.update', $booking->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <x-form.input name="booking_code"
                    label="Код бронювання"
                    :value="$booking->booking_code" required />

                <x-form.input name="group_size"
                    label="Кількість туристів"
                    type="number" min="1"
                    :value="$booking->group_size" required />

                <div class="mb-3">
                    <label class="form-label">Клієнт</label>

                    <select name="user_id"
                        class="form-select @error('user_id') is-invalid @enderror">

                        <option value="">Оберіть клієнта</option>

                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                @selected(old('user_id', $booking->user_id) == $user->id)>
                                {{ $user->full_name }}
                            </option>
                        @endforeach
                    </select>

                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Туристичний виїзд</label>

                    <select name="tour_departure_id"
                        class="form-select @error('tour_departure_id') is-invalid @enderror">

                        <option value="">Оберіть виїзд</option>

                        @foreach ($departures as $departure)
                            <option value="{{ $departure->id }}"
                                @selected(old('tour_departure_id', $booking->tour_departure_id) == $departure->id)>
                                Виїзд #{{ $departure->id }} — {{ $departure->price }} грн
                            </option>
                        @endforeach
                    </select>

                    @error('tour_departure_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <p>
                    <strong>Поточна сума:</strong>
                    {{ $booking->total_amount }} грн
                </p>

                <p class="text-muted">
                    Загальна сума буде перерахована автоматично.
                </p>

                <button type="submit" class="btn btn-primary">
                    Оновити
                </button>

                <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection