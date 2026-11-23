<?php

declare(strict_types=1);

use App\Http\Controllers\BookingController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TourModerationController;
use App\Http\Controllers\TourSearchController;
use Illuminate\Support\Facades\Route;

// Головна сторінка Laravel
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Перевірка стану системи
Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'application' => 'Tour Operator System',
        'timestamp' => now()->toIso8601String(),
    ], 200);
})->name('health');

// Маршрути туристичних пропозицій
Route::prefix('tours')->name('tours.')->group(function () {

    Route::get('/search', [TourSearchController::class, 'search'])
        ->name('search');

    Route::get('/', [TourController::class, 'index'])
        ->name('index');

    Route::post('/', [TourController::class, 'store'])
        ->middleware('tour.manager')
        ->name('store');

    Route::get('/{id}/moderation', [TourModerationController::class, 'index'])
        ->whereNumber('id')
        ->name('moderation.index');

    Route::post('/{id}/moderation', [TourModerationController::class, 'store'])
        ->whereNumber('id')
        ->name('moderation.store');

    Route::get('/{id}', [TourController::class, 'show'])
        ->whereNumber('id')
        ->name('show');
});

// Маршрути бронювань
Route::prefix('bookings')->name('bookings.')->group(function () {

    Route::get('/', [BookingController::class, 'index'])
        ->name('index');

    Route::post('/', [BookingController::class, 'store'])
        ->name('store');

    Route::get('/{id}', [BookingController::class, 'show'])
        ->whereNumber('id')
        ->name('show');
});
