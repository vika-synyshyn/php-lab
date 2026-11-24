@extends('layouts.app')

@section('title', 'Модерація туру')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Модерація туристичної пропозиції</h1>

        <a href="{{ route('tours.moderation.create', $tour->id) }}"
            class="btn btn-primary">
            Додати рішення
        </a>
    </div>

    <p><strong>Тур:</strong> {{ $tour->title }}</p>
    <p><strong>Поточний статус:</strong> {{ $tour->status }}</p>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Модератор</th>
                <th>Рішення</th>
                <th>Причина</th>
                <th>Дата</th>
                <th>Дії</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->moderator->full_name }}</td>
                    <td>{{ $record->decision }}</td>
                    <td>{{ $record->reason ?? '—' }}</td>
                    <td>{{ $record->created_at }}</td>
                    <td>
                        <a href="{{ route('tours.moderation.edit', [$tour->id, $record->id]) }}"
                            class="btn btn-sm btn-warning">
                            Редагувати
                        </a>

                        <form action="{{ route('tours.moderation.destroy', [$tour->id, $record->id]) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Дійсно видалити рішення модерації?');">

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
                        Історія модерації відсутня.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <a href="{{ route('tours.index') }}" class="btn btn-secondary">
        Назад до каталогу
    </a>
@endsection