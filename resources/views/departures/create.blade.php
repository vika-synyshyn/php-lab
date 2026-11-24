@extends('layouts.app')

@section('title', 'Створення виїзду')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Створення туристичного виїзду</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('departures.store') }}" method="POST" novalidate>
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

                <x-form.input name="departure_date"
                    label="Дата виїзду" type="date" required />

                <x-form.input name="capacity"
                    label="Загальна кількість місць"
                    type="number" min="1" required />

                <x-form.input name="available_places"
                    label="Доступні місця"
                    type="number" min="0" required />

                <x-form.input name="price"
                    label="Ціна"
                    type="number" min="0" step="0.01" required />

                <x-form.input name="status"
                    label="Статус" value="scheduled" required />

                <button type="submit" class="btn btn-success">
                    Зберегти
                </button>

                <a href="{{ route('departures.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection