@extends('layouts.app')

@section('title', 'Редагування дня подорожі')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Редагування дня подорожі</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('itinerary.update', $day->id) }}"
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
                                @selected(old('tour_id', $day->tour_id) == $tour->id)>
                                {{ $tour->title }}
                            </option>
                        @endforeach
                    </select>

                    @error('tour_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <x-form.input name="day_number"
                    label="Номер дня" type="number" min="1"
                    :value="$day->day_number" required />

                <x-form.input name="title"
                    label="Назва дня подорожі"
                    :value="$day->title" required />

                <x-form.input name="activities"
                    label="Заплановані заходи"
                    :value="$day->activities" required />

                <button type="submit" class="btn btn-primary">
                    Оновити
                </button>

                <a href="{{ route('itinerary.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection