@extends('layouts.app')

@section('title', 'Створення користувача')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Створення користувача</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('users.store') }}" method="POST" novalidate>
                @csrf

                <x-form.input name="full_name"
                    label="Повне ім'я" required />

                <x-form.input name="email"
                    label="Електронна адреса" type="email" required />

                <div class="mb-3">
                    <label class="form-label">Пароль</label>

                    <input type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required>

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Роль</label>

                    <select name="role"
                        class="form-select @error('role') is-invalid @enderror">

                        <option value="">Оберіть роль</option>

                        <option value="customer" @selected(old('role') == 'customer')>
                            Клієнт
                        </option>

                        <option value="manager" @selected(old('role') == 'manager')>
                            Менеджер
                        </option>

                        <option value="admin" @selected(old('role') == 'admin')>
                            Адміністратор
                        </option>
                    </select>

                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">
                    Зберегти
                </button>

                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection