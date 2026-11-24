@extends('layouts.app')

@section('title', 'Вхід до системи')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h2>Вхід до системи</h2>
                </div>

                <div class="card-body">
                    <form action="{{ route('login.store') }}"
                        method="POST" novalidate>

                        @csrf

                        <x-form.input name="email"
                            label="Електронна адреса"
                            type="email" required />

                        <div class="mb-3">
                            <label class="form-label">Пароль</label>

                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                required>

                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Увійти
                        </button>

                        <a href="{{ route('home') }}" class="btn btn-secondary">
                            Скасувати
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection