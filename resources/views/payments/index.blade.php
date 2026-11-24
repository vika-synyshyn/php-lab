@extends('layouts.app')

@section('title', 'Платежі')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Список платежів</h1>

        <a href="{{ route('payments.create') }}" class="btn btn-primary">
            Додати платіж
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Код бронювання</th>
                <th>Сума</th>
                <th>Спосіб оплати</th>
                <th>Статус</th>
                <th>Дата оплати</th>
                <th>Дії</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->booking->booking_code }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->method }}</td>
                    <td>{{ $payment->status }}</td>
                    <td>{{ $payment->paid_at ?? '—' }}</td>
                    <td>
                        <a href="{{ route('payments.edit', $payment->id) }}"
                            class="btn btn-sm btn-warning">
                            Редагувати
                        </a>

                        <form action="{{ route('payments.destroy', $payment->id) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Дійсно видалити платіж?');">

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
                        Платежів не знайдено.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $payments->links('pagination::bootstrap-5') }}
@endsection