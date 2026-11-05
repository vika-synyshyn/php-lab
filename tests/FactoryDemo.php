<?php

declare(strict_types=1);

namespace Tests;

use App\Core\EntityFactory;
use App\Models\Booking;
use App\Models\Tour;
use InvalidArgumentException;

require_once __DIR__.'/../vendor/autoload.php';

$factory = new EntityFactory;

echo 'Перевірка патерна Factory:'.PHP_EOL;

// Створення туристичного туру
$tour = $factory->createEntity('tour', [
    'id' => 'T002',
    'createdAt' => '2026-11-05',
    'destination' => 'Італія',
    'price' => 25000.00,
]);

echo PHP_EOL.'Створення туру:'.PHP_EOL;
echo $tour->getDetails().PHP_EOL;

// Створення бронювання
$booking = $factory->createEntity('booking', [
    'id' => 'B001',
    'createdAt' => '2026-11-05',
    'customerName' => 'Олена Петренко',
    'tourId' => 'T002',
    'travelers' => 2,
]);

echo PHP_EOL.'Створення бронювання:'.PHP_EOL;
echo $booking->getDetails().PHP_EOL;

// Перевірка типів об'єктів
echo PHP_EOL.'Перевірка типів:'.PHP_EOL;

echo $tour instanceof Tour
    ? 'Tour створено правильно'.PHP_EOL
    : 'Помилка створення Tour'.PHP_EOL;

echo $booking instanceof Booking
    ? 'Booking створено правильно'.PHP_EOL
    : 'Помилка створення Booking'.PHP_EOL;

// Перевірка невідомого типу
echo PHP_EOL.'Перевірка обробки помилки:'.PHP_EOL;

try {
    $factory->createEntity('unknown', []);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage().PHP_EOL;
}
