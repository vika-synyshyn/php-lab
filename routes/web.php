<?php

declare(strict_types=1);

use App\Http\Controllers\TourController;
use App\Http\Controllers\TourSearchController;
use Illuminate\Support\Facades\Route;

// Головна сторінка Laravel
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Службовий маршрут перевірки стану системи
Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'application' => 'Tour Operator System',
        'timestamp' => now()->toIso8601String(),
    ], 200);
})->name('health');

// Маршрути електронної системи туристичного оператора
Route::prefix('tours')->name('tours.')->group(function () {

    // Пошук і фільтрація туристичних пропозицій
    Route::get('/search', [TourSearchController::class, 'search'])
        ->name('search');

    // Отримання списку туристичних пропозицій
    Route::get('/', [TourController::class, 'index'])
        ->name('index');

    // Створення нової туристичної пропозиції
    Route::post('/', [TourController::class, 'store'])
        ->middleware('tour.manager')
        ->name('store');

    // Перегляд конкретного туру за числовим ID
    Route::get('/{id}', [TourController::class, 'show'])
        ->whereNumber('id')
        ->name('show');
});
