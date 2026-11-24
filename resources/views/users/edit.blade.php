@extends('layouts.app')

@section('title', 'Редагування користувача')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Редагування користувача</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}"
                method="POST" novalidate>

                @csrf
                @method('PUT')

                <x-form.input name="full_name"
                    label="Повне ім'я"
                    :value="$user->full_name" required />

                <x-form.input name="email"
                    label="Електронна адреса" type="email"
                    :value="$user->email" required />

                <div class="mb-3">
                    <label class="form-label">Новий пароль</label>

                    <input type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror">

                    <div class="form-text">
                        Залиште порожнім, якщо не потрібно змінювати пароль.
                    </div>

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Роль</label>

                    <select name="role"
                        class="form-select @error('role') is-invalid @enderror">

                        <option value="customer"
                            @selected(old('role', $user->role) == 'customer')>
                            Клієнт
                        </option>

                        <option value="manager"
                            @selected(old('role', $user->role) == 'manager')>
                            Менеджер
                        </option>

                        <option value="admin"
                            @selected(old('role', $user->role) == 'admin')>
                            Адміністратор
                        </option>
                    </select>

                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Оновити
                </button>

                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection