@extends('layouts.app')

@section('title', 'Програма туристичних подорожей')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Програма туристичних подорожей</h1>

        <a href="{{ route('itinerary.create') }}" class="btn btn-primary">
            Додати день подорожі
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Тур</th>
                <th>Номер дня</th>
                <th>Назва</th>
                <th>Заплановані заходи</th>
                <th>Дії</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($days as $day)
                <tr>
                    <td>{{ $day->id }}</td>
                    <td>{{ $day->tour->title }}</td>
                    <td>{{ $day->day_number }}</td>
                    <td>{{ $day->title }}</td>
                    <td>{{ $day->activities }}</td>
                    <td>
                        <a href="{{ route('itinerary.edit', $day->id) }}"
                            class="btn btn-sm btn-warning">
                            Редагувати
                        </a>

                        <form action="{{ route('itinerary.destroy', $day->id) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Дійсно видалити день подорожі?');">

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
                        Програму туристичних подорожей ще не сформовано.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $days->links('pagination::bootstrap-5') }}
@endsection