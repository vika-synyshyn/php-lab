<?php

declare(strict_types=1);

namespace Tests;

use App\Tasks\SquareMatrix;
use InvalidArgumentException;

require_once __DIR__.'/../vendor/autoload.php';

echo 'Перевірка класу SquareMatrix:'.PHP_EOL;

// 1. Створення матриці 3x3
$data = [
    [2, 1, 3],
    [0, 4, 5],
    [1, 2, 6],
];

$matrix = new SquareMatrix($data);

echo PHP_EOL.'1. Початкова матриця:'.PHP_EOL;

foreach ($matrix->getMatrix() as $row) {
    echo implode("\t", $row).PHP_EOL;
}

// 2. Сума головної діагоналі
echo PHP_EOL.'2. Сума головної діагоналі:'.PHP_EOL;

$diagonalSum = $matrix->calculateDiagonalSum();

echo "Сума: {$diagonalSum}".PHP_EOL;
echo $diagonalSum === 12
    ? 'Розрахунок правильний'.PHP_EOL
    : 'Помилка розрахунку'.PHP_EOL;

// 3. Визначник матриці
echo PHP_EOL.'3. Визначник матриці:'.PHP_EOL;

$determinant = $matrix->calculateDeterminant();

echo "Визначник: {$determinant}".PHP_EOL;
echo abs($determinant - 21) < 0.000001
    ? 'Розрахунок правильний'.PHP_EOL
    : 'Помилка розрахунку'.PHP_EOL;

// 4. Перевірка некоректного розміру
echo PHP_EOL.'4. Перевірка некоректної матриці:'.PHP_EOL;

try {
    new SquareMatrix([
        [1, 2],
        [3, 4],
    ]);
} catch (InvalidArgumentException $e) {
    echo 'Помилку оброблено: '
        .$e->getMessage().PHP_EOL;
}

// 5. Перевірка некоректних елементів
echo PHP_EOL.'5. Перевірка типів елементів:'.PHP_EOL;

try {
    new SquareMatrix([
        [1, 2, 3],
        [4, 'abc', 6],
        [7, 8, 9],
    ]);
} catch (InvalidArgumentException $e) {
    echo 'Помилку оброблено: '
        .$e->getMessage().PHP_EOL;
}
