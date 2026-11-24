@extends('layouts.app')

@section('title', 'Редагування виїзду')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Редагування туристичного виїзду</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('departures.update', $departure->id) }}"
                method="POST" novalidate>

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Туристична пропозиція</label>

                    <select name="tour_id"
                        class="form-select @error('tour_id') is-invalid @enderror">

                        <option value="">Оберіть тур</option>

                        @foreach ($tours as $tour)
                            <option value="{{ $tour->id }}"
                                @selected(old('tour_id', $departure->tour_id) == $tour->id)>
                                {{ $tour->title }}
                            </option>
                        @endforeach
                    </select>

                    @error('tour_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <x-form.input name="departure_date"
                    label="Дата виїзду" type="date"
                    :value="$departure->departure_date" required />

                <x-form.input name="capacity"
                    label="Загальна кількість місць"
                    type="number" min="1"
                    :value="$departure->capacity" required />

                <x-form.input name="available_places"
                    label="Доступні місця"
                    type="number" min="0"
                    :value="$departure->available_places" required />

                <x-form.input name="price"
                    label="Ціна"
                    type="number" min="0" step="0.01"
                    :value="$departure->price" required />

                <x-form.input name="status"
                    label="Статус"
                    :value="$departure->status" required />

                <button type="submit" class="btn btn-primary">
                    Оновити
                </button>

                <a href="{{ route('departures.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection