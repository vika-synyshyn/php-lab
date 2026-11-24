<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\ItineraryDayController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TourCategoryController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TourDepartureController;
use App\Http\Controllers\TourModerationController;
use App\Http\Controllers\TourSearchController;
use App\Http\Controllers\TravelerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Головна сторінка
Route::get('/', function () {
    return view('home');
})->name('home');

// Маршрути автентифікації
Route::get('/login', [AuthController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'store'])
    ->middleware(['guest', 'throttle:5,1'])
    ->name('login.store');

Route::post('/logout', [AuthController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

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

    Route::get('/create', [TourController::class, 'create'])
        ->middleware('tour.manager')
        ->name('create');

    Route::post('/', [TourController::class, 'store'])
        ->middleware('tour.manager')
        ->name('store');

    // Маршрути модерації
    Route::get('/{id}/moderation', [TourModerationController::class, 'index'])
        ->whereNumber('id')
        ->name('moderation.index');

    Route::get('/{id}/moderation/create', [TourModerationController::class, 'create'])
        ->whereNumber('id')
        ->name('moderation.create');

    Route::post('/{id}/moderation', [TourModerationController::class, 'store'])
        ->whereNumber('id')
        ->name('moderation.store');

    Route::get('/{id}/moderation/{recordId}/edit', [TourModerationController::class, 'edit'])
        ->whereNumber(['id', 'recordId'])
        ->name('moderation.edit');

    Route::put('/{id}/moderation/{recordId}', [TourModerationController::class, 'update'])
        ->whereNumber(['id', 'recordId'])
        ->name('moderation.update');

    Route::delete('/{id}/moderation/{recordId}', [TourModerationController::class, 'destroy'])
        ->whereNumber(['id', 'recordId'])
        ->name('moderation.destroy');

    Route::get('/{id}/edit', [TourController::class, 'edit'])
        ->middleware('tour.manager')
        ->whereNumber('id')
        ->name('edit');

    Route::put('/{id}', [TourController::class, 'update'])
        ->middleware('tour.manager')
        ->whereNumber('id')
        ->name('update');

    Route::delete('/{id}', [TourController::class, 'destroy'])
        ->middleware('tour.manager')
        ->whereNumber('id')
        ->name('destroy');

    Route::get('/{id}', [TourController::class, 'show'])
        ->whereNumber('id')
        ->name('show');
});

// Маршрути бронювань
Route::prefix('bookings')->name('bookings.')->group(function () {

    Route::get('/', [BookingController::class, 'index'])
        ->name('index');

    Route::get('/create', [BookingController::class, 'create'])
        ->name('create');

    Route::post('/', [BookingController::class, 'store'])
        ->name('store');

    Route::get('/{id}/edit', [BookingController::class, 'edit'])
        ->whereNumber('id')
        ->name('edit');

    Route::put('/{id}', [BookingController::class, 'update'])
        ->whereNumber('id')
        ->name('update');

    Route::delete('/{id}', [BookingController::class, 'destroy'])
        ->whereNumber('id')
        ->name('destroy');

    Route::get('/{id}', [BookingController::class, 'show'])
        ->whereNumber('id')
        ->name('show');
});

// Маршрути, доступні менеджеру
Route::middleware('tour.manager')->group(function () {

    // Маршрути категорій
    Route::resource('categories', TourCategoryController::class)
        ->except(['show']);

    // Маршрути туристичних напрямків
    Route::resource('destinations', DestinationController::class)
        ->except(['show']);

    // Маршрути готелів
    Route::resource('hotels', HotelController::class)
        ->except(['show']);

    // Маршрути туристичних виїздів
    Route::resource('departures', TourDepartureController::class)
        ->except(['show']);

    // Маршрути програми туристичної подорожі
    Route::resource('itinerary', ItineraryDayController::class)
        ->parameters(['itinerary' => 'day'])
        ->except(['show']);

    // Маршрути туристів
    Route::resource('travelers', TravelerController::class)
        ->except(['show']);

    // Маршрути платежів
    Route::resource('payments', PaymentController::class)
        ->except(['show']);
});

// Маршрути користувачів
Route::resource('users', UserController::class)
    ->except(['show']);
