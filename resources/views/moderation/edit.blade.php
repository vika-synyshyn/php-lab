@extends('layouts.app')

@section('title', 'Редагування рішення модерації')

@section('content')
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Редагування рішення модерації</h2>
        </div>

        <div class="card-body">
            <p><strong>Тур:</strong> {{ $tour->title }}</p>

            <p><strong>Модератор:</strong>
                {{ $record->moderator->full_name }}
            </p>

            <form action="{{ route('tours.moderation.update', [$tour->id, $record->id]) }}"
                method="POST" novalidate>

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Рішення</label>

                    <select name="decision"
                        class="form-select @error('decision') is-invalid @enderror">

                        <option value="approved"
                            @selected(old('decision', $record->decision) == 'approved')>
                            Схвалити
                        </option>

                        <option value="rejected"
                            @selected(old('decision', $record->decision) == 'rejected')>
                            Відхилити
                        </option>
                    </select>

                    @error('decision')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <x-form.input name="reason"
                    label="Причина рішення"
                    :value="$record->reason ?? ''" />

                <button type="submit" class="btn btn-primary">
                    Оновити
                </button>

                <a href="{{ route('tours.moderation.index', $tour->id) }}"
                    class="btn btn-secondary">
                    Скасувати
                </a>
            </form>
        </div>
    </div>
@endsection