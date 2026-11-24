@extends('layouts.app')

@section('title', 'Готелі')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Готелі</h1>

        <a href="{{ route('hotels.create') }}" class="btn btn-primary">
            Додати готель
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Назва готелю</th>
                <th>Кількість зірок</th>
                <th>Адреса</th>
                <th>Напрямок</th>
                <th>Кількість турів</th>
                <th>Дії</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($hotels as $hotel)
                <tr>
                    <td>{{ $hotel->id }}</td>
                    <td>{{ $hotel->name }}</td>
                    <td>{{ $hotel->stars }}</td>
                    <td>{{ $hotel->address }}</td>
                    <td>
                        {{ $hotel->destination->country ?? '' }},
                        {{ $hotel->destination->city ?? '' }}
                    </td>
                    <td>{{ $hotel->tours_count }}</td>
                    <td>
                        <a href="{{ route('hotels.edit', $hotel->id) }}"
                            class="btn btn-sm btn-warning">
                            Редагувати
                        </a>

                        <form action="{{ route('hotels.destroy', $hotel->id) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Дійсно видалити готель?');">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-sm btn-danger">
                                Видалити
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">
                        Готелів не знайдено.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $hotels->links('pagination::bootstrap-5') }}
@endsection