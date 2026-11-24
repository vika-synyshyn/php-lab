@extends('layouts.app')

@section('title', 'Бронювання')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Список бронювань</h1>

        <a href="{{ route('bookings.create') }}" class="btn btn-primary">
            Додати бронювання
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Код бронювання</th>
                <th>Клієнт</th>
                <th>ID виїзду</th>
                <th>Кількість туристів</th>
                <th>Загальна сума</th>
                <th>Статус</th>
                <th>Дії</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->booking_code }}</td>
                    <td>{{ $booking->customer->full_name ?? 'Немає' }}</td>
                    <td>{{ $booking->departure->id ?? 'Немає' }}</td>
                    <td>{{ $booking->group_size }}</td>
                    <td>{{ $booking->total_amount }}</td>
                    <td>{{ $booking->status }}</td>
                    <td>
                        <a href="{{ route('bookings.show', $booking->id) }}"
                            class="btn btn-sm btn-info">
                            Перегляд
                        </a>

                        @if (auth()->user()?->role === 'manager')
                            <a href="{{ route('bookings.edit', $booking->id) }}"
                                class="btn btn-sm btn-warning">
                                Редагувати
                            </a>

                            <form action="{{ route('bookings.destroy', $booking->id) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Дійсно видалити бронювання?');">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger">
                                    Видалити
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">
                        Бронювань не знайдено.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $bookings->links('pagination::bootstrap-5') }}
@endsection