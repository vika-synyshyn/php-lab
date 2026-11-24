@extends('layouts.app')

@section('title', 'Категорії турів')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Категорії туристичних пропозицій</h1>

        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            Додати категорію
        </a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Назва категорії</th>
                <th>Кількість турів</th>
                <th>Дії</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->tours_count }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category->id) }}"
                            class="btn btn-sm btn-warning">
                            Редагувати
                        </a>

                        <form action="{{ route('categories.destroy', $category->id) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Дійсно видалити категорію?');">

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
                    <td colspan="4" class="text-center">
                        Категорій не знайдено.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $categories->links('pagination::bootstrap-5') }}
@endsection