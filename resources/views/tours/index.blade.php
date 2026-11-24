@extends('layouts.app')

@section('title', 'Каталог турів')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Каталог туристичних пропозицій</h1>

        @if (auth()->user()?->role === 'manager')
            <a href="{{ route('tours.create') }}" class="btn btn-primary">
                Додати новий тур
            </a>
        @endif
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Назва</th>
                <th>Категорія</th>
                <th>Напрямок</th>
                <th>Готелі</th>
                <th>Тривалість</th>
                <th>Ціна</th>
                <th>Статус</th>
                <th>Дії</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($tours as $tour)
                <tr>
                    <td>{{ $tour->id }}</td>
                    <td>{{ $tour->title }}</td>
                    <td>{{ $tour->category->name ?? 'Немає' }}</td>
                    <td>
                        {{ $tour->destination->country ?? '' }},
                        {{ $tour->destination->city ?? '' }}
                    </td>
                    <td>
                        @forelse ($tour->hotels as $hotel)
                            <span class="badge bg-secondary">
                                {{ $hotel->name }}
                            </span>
                        @empty
                            —
                        @endforelse
                    </td>
                    <td>{{ $tour->duration_days }} дн.</td>
                    <td>{{ $tour->base_price }}</td>
                    <td>{{ $tour->status }}</td>
                    <td>
                        <a href="{{ route('tours.show', $tour->id) }}"
                            class="btn btn-sm btn-info">
                            Перегляд
                        </a>

                        @if (auth()->user()?->role === 'manager')
                            <a href="{{ route('tours.edit', $tour->id) }}"
                                class="btn btn-sm btn-warning">
                                Редагувати
                            </a>

                            <form action="{{ route('tours.destroy', $tour->id) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Дійсно видалити тур?');">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger">
                                    Видалити
                                </button>
                            </form>
                        @endif

                        @if (auth()->user()?->role === 'admin')
                            <a href="{{ route('tours.moderation.index', $tour->id) }}"
                                class="btn btn-sm btn-info">
                                Модерація
                            </a>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center">
                        Туристичних пропозицій не знайдено.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $tours->links('pagination::bootstrap-5') }}
@endsection