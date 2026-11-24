@extends('layouts.app')

@section('title', 'Деталі бронювання')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Бронювання {{ $booking->booking_code }}</h2>
        </div>

        <div class="card-body">
            <p><strong>ID:</strong> {{ $booking->id }}</p>

            <p><strong>Клієнт:</strong>
                {{ $booking->customer->full_name ?? 'Немає' }}
            </p>

            <p><strong>ID виїзду:</strong>
                {{ $booking->departure->id ?? 'Немає' }}
            </p>

            <p><strong>Кількість заброньованих місць:</strong>
                {{ $booking->group_size }}
            </p>

            <p><strong>Загальна сума:</strong>
                {{ $booking->total_amount }}
            </p>

            <p><strong>Статус:</strong>
                {{ $booking->status }}
            </p>

            <h4>Туристи</h4>

            <p>Кількість зареєстрованих туристів:
                {{ $booking->travelers->count() }}
            </p>

            <h4>Платежі</h4>

            <p>Кількість платежів:
                {{ $booking->payments->count() }}
            </p>

            <a href="{{ route('bookings.index') }}"
                class="btn btn-secondary">
                Назад до списку
            </a>

            @if (auth()->user()?->role === 'manager')
                <a href="{{ route('bookings.edit', $booking->id) }}"
                    class="btn btn-warning">
                    Редагувати
                </a>

                <form action="{{ route('bookings.destroy', $booking->id) }}"
                    method="POST"
                    class="d-inline"
                    onsubmit="return confirm('Дійсно видалити бронювання?');">

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        Видалити
                    </button>
                </form>
            @endif
        </div>
    </div>
@endsection