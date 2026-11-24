@extends('layouts.app')

@section('title', 'Створення категорії')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Створення категорії</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('categories.store') }}" method="POST" novalidate>
                @csrf

                <x-form.input name="name" label="Назва категорії" required />

                <button type="submit" class="btn btn-success">
                    Зберегти
                </button>

                <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection