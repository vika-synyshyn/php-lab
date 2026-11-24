@extends('layouts.app')

@section('title', 'Модерація туристичної пропозиції')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Модерація туру: {{ $tour->title }}</h2>
        </div>

        <div class="card-body">
            <form action="{{ route('tours.moderation.store', $tour->id) }}"
                method="POST" novalidate>

                @csrf

                <p>
                    <strong>Модератор:</strong>
                    {{ auth()->user()->full_name }}
                </p>

                <div class="mb-3">
                    <label class="form-label">Рішення</label>

                    <select name="decision"
                        class="form-select @error('decision') is-invalid @enderror">

                        <option value="">Оберіть рішення</option>

                        <option value="approved" @selected(old('decision') == 'approved')>
                            Схвалити
                        </option>

                        <option value="rejected" @selected(old('decision') == 'rejected')>
                            Відхилити
                        </option>
                    </select>

                    @error('decision')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <x-form.input name="reason" label="Причина рішення" />

                <button type="submit" class="btn btn-success">
                    Зберегти рішення
                </button>

                <a href="{{ route('tours.moderation.index', $tour->id) }}"
                    class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection