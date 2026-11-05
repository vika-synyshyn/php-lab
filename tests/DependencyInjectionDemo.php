<?php

declare(strict_types=1);

namespace Tests;

use App\Services\ConsoleLogger;
use App\Services\EntityService;
use App\Services\FileLogger;

require_once __DIR__.'/../vendor/autoload.php';

echo 'Перевірка Dependency Injection:'.PHP_EOL;

// 1. Логування в консоль
echo PHP_EOL.'ConsoleLogger:'.PHP_EOL;

$consoleService = new EntityService(
    new ConsoleLogger
);

$total = $consoleService->calculateTourTotal(5000, 3);
$discounted = $consoleService->applyDiscount($total, 10);

echo "Підсумкова вартість: {$discounted} грн".PHP_EOL;

// 2. Логування у файл
echo PHP_EOL.'FileLogger:'.PHP_EOL;

$fileService = new EntityService(
    new FileLogger
);

$fileTotal = $fileService->calculateTourTotal(5000, 3);
$fileDiscounted = $fileService->applyDiscount($fileTotal, 10);

echo "Підсумкова вартість: {$fileDiscounted} грн".PHP_EOL;

echo PHP_EOL.'Перевірка файлу журналу:'.PHP_EOL;

$logPath = dirname(__DIR__).'/storage/logs/app.log';

if (is_file($logPath)) {
    echo 'Файл журналу успішно створено!'.PHP_EOL;
} else {
    echo 'Помилка: файл журналу не знайдено!'.PHP_EOL;
}
