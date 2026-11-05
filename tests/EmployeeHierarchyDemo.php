<?php

declare(strict_types=1);

namespace Tests;

use App\Tasks\CompanyManager;
use App\Tasks\DepartmentHead;
use App\Tasks\ShopManager;
use App\Tasks\Worker;

require_once __DIR__.'/../vendor/autoload.php';

echo 'Перевірка ієрархії працівників:'.PHP_EOL;

// Створення працівників із однаковою базовою зарплатою
$employees = [
    new ShopManager('Іван Петренко', 20000.0),
    new DepartmentHead('Олена Коваль', 20000.0),
    new CompanyManager('Марія Мельник', 20000.0),
];

$expectedSalaries = [22000.0, 25000.0, 30000.0];

echo PHP_EOL.'1. Розрахунок заробітної плати:'.PHP_EOL;

foreach ($employees as $index => $employee) {
    echo $employee->getRoleDetails().PHP_EOL;
}

// Перевірка поліморфізму
echo PHP_EOL.'2. Перевірка поліморфізму:'.PHP_EOL;

foreach ($employees as $index => $employee) {
    if (
        $employee instanceof Worker &&
        abs(
            $employee->calculateSalary()
            - $expectedSalaries[$index]
        ) < 0.001
    ) {
        echo 'Працівник '.($index + 1)
            .': розрахунок правильний'.PHP_EOL;
    } else {
        echo 'Працівник '.($index + 1)
            .': помилка розрахунку'.PHP_EOL;
    }
}

// Перевірка обробки некоректних даних
echo PHP_EOL."3. Перевірка від'ємної зарплати:".PHP_EOL;

try {
    new ShopManager('Тестовий працівник', -1000.0);
} catch (\InvalidArgumentException $e) {
    echo 'Помилку оброблено: '
        .$e->getMessage().PHP_EOL;
}
