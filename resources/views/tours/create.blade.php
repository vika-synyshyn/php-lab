@extends('layouts.app')

@section('title', 'Створення туристичної пропозиції')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Створення туристичної пропозиції</h2>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    Виправте помилки у формі.
                </div>
            @endif

            <form action="{{ route('tours.store') }}" method="POST" novalidate>
                @csrf

                <x-form.input name="title" label="Назва туру" required />

                <x-form.input name="duration_days" label="Тривалість (днів)"
                    type="number" min="1" required />

                <x-form.input name="base_price" label="Базова ціна"
                    type="number" step="0.01" min="0" required />

                <x-form.input name="description" label="Опис туру" />

                <div class="mb-3">
                    <label class="form-label">Менеджер</label>

                    <select name="manager_id"
                        class="form-select @error('manager_id') is-invalid @enderror">

                        <option value="">Оберіть менеджера</option>

                        @foreach ($managers as $manager)
                            <option value="{{ $manager->id }}"
                                @selected(old('manager_id') == $manager->id)>
                                {{ $manager->full_name }}
                            </option>
                        @endforeach
                    </select>

                    @error('manager_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Категорія</label>

                    <select name="category_id"
                        class="form-select @error('category_id') is-invalid @enderror">

                        <option value="">Оберіть категорію</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(old('category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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

                <div class="mb-3">
                    <label class="form-label d-block">Готелі</label>

                    @foreach ($hotels as $hotel)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input"
                                type="checkbox"
                                name="hotel_ids[]"
                                id="hotel_{{ $hotel->id }}"
                                value="{{ $hotel->id }}"
                                @checked(in_array($hotel->id, old('hotel_ids', [])))>

                            <label class="form-check-label"
                                for="hotel_{{ $hotel->id }}">
                                {{ $hotel->name }}
                            </label>
                        </div>
                    @endforeach

                    @error('hotel_ids')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    @error('hotel_ids.*')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    Зберегти
                </button>

                <a href="{{ route('tours.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection