@extends('layouts.app')

@section('title', $tour->title)

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>{{ $tour->title }}</h2>
        </div>

        <div class="card-body">
            <p><strong>ID:</strong> {{ $tour->id }}</p>

            <p><strong>Категорія:</strong> {{ $tour->category->name }}</p>

            <p><strong>Напрямок:</strong>
                {{ $tour->destination->country }},
                {{ $tour->destination->city }}
            </p>

            <p><strong>Менеджер:</strong> {{ $tour->manager->full_name }}</p>

            <p><strong>Тривалість:</strong> {{ $tour->duration_days }} дн.</p>

            <p><strong>Ціна:</strong> {{ $tour->base_price }}</p>

            <p><strong>Статус:</strong> {{ $tour->status }}</p>

            <p><strong>Опис:</strong> {{ $tour->description }}</p>

            <h4>Готелі</h4>

            <ul>
                @forelse ($tour->hotels as $hotel)
                    <li>{{ $hotel->name }} ({{ $hotel->stars }} зірок)</li>
                @empty
                    <li>Готелі відсутні.</li>
                @endforelse
            </ul>

            <h4>Програма туру</h4>

            <ul>
                @forelse ($tour->itineraryDays as $day)
                    <li>
                        День {{ $day->day_number }}:
                        {{ $day->title }} — {{ $day->activities }}
                    </li>
                @empty
                    <li>Програму туру ще не сформовано.</li>
                @endforelse
            </ul>

            <a href="{{ route('tours.index') }}" class="btn btn-secondary">
                Назад до каталогу
            </a>

            @if (auth()->user()?->role === 'manager')
                <a href="{{ route('tours.edit', $tour->id) }}"
                    class="btn btn-warning">
                    Редагувати
                </a>

                <form action="{{ route('tours.destroy', $tour->id) }}"
                    method="POST"
                    class="d-inline"
                    onsubmit="return confirm('Дійсно видалити тур?');">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        Видалити
                    </button>
                </form>
            @endif

            @if (auth()->user()?->role === 'admin')
                <a href="{{ route('tours.moderation.index', $tour->id) }}"
                    class="btn btn-info">
                    Модерація
                </a>
            @endif
        </div>
    </div>
@endsection