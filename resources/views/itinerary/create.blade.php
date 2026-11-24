@extends('layouts.app')

@section('title', 'Створення дня подорожі')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Створення дня подорожі</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('itinerary.store') }}" method="POST" novalidate>
                @csrf

                <div class="mb-3">
                    <label class="form-label">Туристична пропозиція</label>

                    <select name="tour_id"
                        class="form-select @error('tour_id') is-invalid @enderror">

                        <option value="">Оберіть тур</option>

                        @foreach ($tours as $tour)
                            <option value="{{ $tour->id }}"
                                @selected(old('tour_id') == $tour->id)>
                                {{ $tour->title }}
                            </option>
                        @endforeach
                    </select>

                    @error('tour_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <x-form.input name="day_number"
                    label="Номер дня" type="number" min="1" required />

                <x-form.input name="title"
                    label="Назва дня подорожі" required />

                <x-form.input name="activities"
                    label="Заплановані заходи" required />

                <button type="submit" class="btn btn-success">
                    Зберегти
                </button>

                <a href="{{ route('itinerary.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection