@extends('layouts.app')

@section('title', 'Редагування готелю')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Редагування готелю</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('hotels.update', $hotel->id) }}"
                method="POST" novalidate>

                @csrf
                @method('PUT')

                <x-form.input name="name" label="Назва готелю"
                    :value="$hotel->name" required />

                <x-form.input name="stars" label="Кількість зірок"
                    type="number" min="1" max="5"
                    :value="$hotel->stars" required />

                <x-form.input name="address" label="Адреса"
                    :value="$hotel->address" required />

                <div class="mb-3">
                    <label class="form-label">Туристичний напрямок</label>

                    <select name="destination_id"
                        class="form-select @error('destination_id') is-invalid @enderror">

                        <option value="">Оберіть напрямок</option>

                        @foreach ($destinations as $destination)
                            <option value="{{ $destination->id }}"
                                @selected(old('destination_id', $hotel->destination_id) == $destination->id)>
                                {{ $destination->country }},
                                {{ $destination->city }}
                            </option>
                        @endforeach
                    </select>

                    @error('destination_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Оновити
                </button>

                <a href="{{ route('hotels.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection