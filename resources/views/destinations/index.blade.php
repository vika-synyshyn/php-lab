@extends('layouts.app')

@section('title', 'Туристичні напрямки')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Туристичні напрямки</h1>

        <a href="{{ route('destinations.create') }}" class="btn btn-primary">
            Додати напрямок
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Країна</th>
                <th>Регіон</th>
                <th>Місто</th>
                <th>Кількість турів</th>
                <th>Кількість готелів</th>
                <th>Дії</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($destinations as $destination)
                <tr>
                    <td>{{ $destination->id }}</td>
                    <td>{{ $destination->country }}</td>
                    <td>{{ $destination->region }}</td>
                    <td>{{ $destination->city }}</td>
                    <td>{{ $destination->tours_count }}</td>
                    <td>{{ $destination->hotels_count }}</td>

                    <td>
                        <a href="{{ route('destinations.edit', $destination->id) }}"
                            class="btn btn-sm btn-warning">
                            Редагувати
                        </a>

                        <form action="{{ route('destinations.destroy', $destination->id) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Дійсно видалити напрямок?');">

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
                        Туристичних напрямків не знайдено.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $destinations->links('pagination::bootstrap-5') }}
@endsection