@extends('layouts.app')

@section('title', 'Користувачі')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Список користувачів</h1>

        <a href="{{ route('users.create') }}" class="btn btn-primary">
            Додати користувача
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Повне ім'я</th>
                <th>Електронна адреса</th>
                <th>Роль</th>
                <th>Дії</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->full_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}"
                            class="btn btn-sm btn-warning">
                            Редагувати
                        </a>

                        @if (auth()->id() !== $user->id)
                            <form action="{{ route('users.destroy', $user->id) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Дійсно видалити користувача?');">

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
                    <td colspan="5" class="text-center">
                        Користувачів не знайдено.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $users->links('pagination::bootstrap-5') }}
@endsection