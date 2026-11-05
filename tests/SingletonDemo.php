<?php

declare(strict_types=1);

namespace Tests;

use App\Core\Database;

require_once __DIR__.'/../vendor/autoload.php';

echo "Перевірка патерна Singleton:\n";

$db1 = Database::getInstance();
$db2 = Database::getInstance();
$db3 = Database::getInstance();

if ($db1 === $db2 && $db2 === $db3) {
    echo 'Усі змінні посилаються на один екземпляр Database.'.PHP_EOL;
} else {
    echo 'Помилка: створено різні екземпляри Database.'.PHP_EOL;
}
