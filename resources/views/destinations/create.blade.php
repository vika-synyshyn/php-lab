@extends('layouts.app')

@section('title', 'Створення напрямку')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Створення туристичного напрямку</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('destinations.store') }}" method="POST" novalidate>
                @csrf

                <x-form.input name="country" label="Країна" required />

                <x-form.input name="region" label="Регіон" required />

                <x-form.input name="city" label="Місто" required />

                <button type="submit" class="btn btn-success">
                    Зберегти
                </button>

                <a href="{{ route('destinations.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection