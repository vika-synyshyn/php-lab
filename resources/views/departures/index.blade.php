@extends('layouts.app')

@section('title', 'Туристичні виїзди')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Туристичні виїзди</h1>

        <a href="{{ route('departures.create') }}" class="btn btn-primary">
            Додати виїзд
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Тур</th>
                <th>Дата виїзду</th>
                <th>Кількість місць</th>
                <th>Доступні місця</th>
                <th>Ціна</th>
                <th>Статус</th>
                <th>Бронювання</th>
                <th>Дії</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($departures as $departure)
                <tr>
                    <td>{{ $departure->id }}</td>
                    <td>{{ $departure->tour->title }}</td>
                    <td>{{ $departure->departure_date }}</td>
                    <td>{{ $departure->capacity }}</td>
                    <td>{{ $departure->available_places }}</td>
                    <td>{{ $departure->price }}</td>
                    <td>{{ $departure->status }}</td>
                    <td>{{ $departure->bookings_count }}</td>
                    <td>
                        <a href="{{ route('departures.edit', $departure->id) }}"
                            class="btn btn-sm btn-warning">
                            Редагувати
                        </a>

                        <form action="{{ route('departures.destroy', $departure->id) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Дійсно видалити виїзд?');">

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
                    <td colspan="9" class="text-center">
                        Туристичних виїздів не знайдено.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $departures->links('pagination::bootstrap-5') }}
@endsection