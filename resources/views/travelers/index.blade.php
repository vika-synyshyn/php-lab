@extends('layouts.app')

@section('title', 'Туристи')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Список туристів</h1>

        <a href="{{ route('travelers.create') }}" class="btn btn-primary">
            Додати туриста
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Ім'я</th>
                <th>Прізвище</th>
                <th>Дата народження</th>
                <th>Код бронювання</th>
                <th>Дії</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($travelers as $traveler)
                <tr>
                    <td>{{ $traveler->id }}</td>
                    <td>{{ $traveler->first_name }}</td>
                    <td>{{ $traveler->last_name }}</td>
                    <td>{{ $traveler->birth_date }}</td>
                    <td>{{ $traveler->booking->booking_code }}</td>
                    <td>
                        <a href="{{ route('travelers.edit', $traveler->id) }}"
                            class="btn btn-sm btn-warning">
                            Редагувати
                        </a>

                        <form action="{{ route('travelers.destroy', $traveler->id) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Дійсно видалити туриста?');">

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
                    <td colspan="6" class="text-center">
                        Туристів не знайдено.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $travelers->links('pagination::bootstrap-5') }}
@endsection