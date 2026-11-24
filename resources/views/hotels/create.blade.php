@extends('layouts.app')

@section('title', 'Створення готелю')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Створення готелю</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('hotels.store') }}" method="POST" novalidate>
                @csrf

                <x-form.input name="name" label="Назва готелю" required />

                <x-form.input name="stars" label="Кількість зірок"
                    type="number" min="1" max="5" required />

                <x-form.input name="address" label="Адреса" required />

                <div class="mb-3">
                    <label class="form-label">Туристичний напрямок</label>

                    <select name="destination_id"
                        class="form-select @error('destination_id') is-invalid @enderror">

                        <option value="">Оберіть напрямок</option>

                        @foreach ($destinations as $destination)
                            <option value="{{ $destination->id }}"
                                @selected(old('destination_id') == $destination->id)>
                                {{ $destination->country }},
                                {{ $destination->city }}
                            </option>
                        @endforeach
                    </select>

                    @error('destination_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    Зберегти
                </button>

                <a href="{{ route('hotels.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection