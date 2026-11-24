@extends('layouts.app')

@section('title', 'Пошук турів')

@section('content')
    <h1 class="mb-3">Пошук туристичних пропозицій</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('tours.search') }}" method="GET" novalidate>

                <div class="mb-3">
                    <label class="form-label">Туристичний напрямок</label>

                    <select name="destination_id"
                        class="form-select @error('destination_id') is-invalid @enderror">

                        <option value="">Усі напрямки</option>

                        @foreach ($destinations as $destination)
                            <option value="{{ $destination->id }}"
                                @selected(old('destination_id', $filters['destination_id'] ?? '') == $destination->id)>
                                {{ $destination->country }},
                                {{ $destination->city }}
                            </option>
                        @endforeach
                    </select>

                    @error('destination_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <x-form.input name="max_price"
                    label="Максимальна ціна"
                    type="number" min="0" step="0.01"
                    :value="$filters['max_price'] ?? ''" />

                <x-form.input name="duration_days"
                    label="Тривалість подорожі (днів)"
                    type="number" min="1"
                    :value="$filters['duration_days'] ?? ''" />

                <button type="submit" class="btn btn-primary">
                    Знайти
                </button>

                <a href="{{ route('tours.search') }}" class="btn btn-secondary">
                    Скинути фільтри
                </a>
            </form>
        </div>
    </div>

    <h4>Знайдено туристичних пропозицій: {{ $tours->count() }}</h4>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Назва</th>
                <th>Категорія</th>
                <th>Напрямок</th>
                <th>Тривалість</th>
                <th>Ціна</th>
                <th>Дії</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($tours as $tour)
                <tr>
                    <td>{{ $tour->title }}</td>
                    <td>{{ $tour->category->name }}</td>
                    <td>
                        {{ $tour->destination->country }},
                        {{ $tour->destination->city }}
                    </td>
                    <td>{{ $tour->duration_days }} дн.</td>
                    <td>{{ $tour->base_price }}</td>
                    <td>
                        <a href="{{ route('tours.show', $tour->id) }}"
                            class="btn btn-sm btn-info">
                            Перегляд
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">
                        Туристичних пропозицій не знайдено.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('tours.index') }}" class="btn btn-secondary">
        Назад до каталогу
    </a>
@endsection