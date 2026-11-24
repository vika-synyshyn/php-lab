@extends('layouts.app')

@section('title', 'Головна сторінка')

@section('content')
    <div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
        <h1 class="display-5 fw-bold">
            Електронна система туристичного оператора
        </h1>

        <p class="fs-4">
            Перегляд туристичних пропозицій та управління бронюваннями.
        </p>

        <a href="{{ route('tours.index') }}" class="btn btn-primary">
            Перейти до каталогу турів
        </a>
    </div>
@endsection