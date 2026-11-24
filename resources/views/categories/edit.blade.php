@extends('layouts.app')

@section('title', 'Редагування категорії')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Редагування категорії</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('categories.update', $category->id) }}"
                method="POST" novalidate>

                @csrf
                @method('PUT')

                <x-form.input name="name" label="Назва категорії"
                    :value="$category->name" required />

                <button type="submit" class="btn btn-primary">
                    Оновити
                </button>

                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection