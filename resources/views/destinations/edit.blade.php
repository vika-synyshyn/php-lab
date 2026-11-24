@extends('layouts.app')

@section('title', 'Редагування напрямку')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Редагування туристичного напрямку</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('destinations.update', $destination->id) }}"
                method="POST" novalidate>

                @csrf
                @method('PUT')

                <x-form.input name="country" label="Країна"
                    :value="$destination->country" required />

                <x-form.input name="region" label="Регіон"
                    :value="$destination->region" required />

                <x-form.input name="city" label="Місто"
                    :value="$destination->city" required />

                <button type="submit" class="btn btn-primary">
                    Оновити
                </button>

                <a href="{{ route('destinations.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection