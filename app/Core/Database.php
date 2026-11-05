<?php

declare(strict_types=1);

namespace App\Core;

final class Database
{
    private static ?self $instance = null;

    private function __construct()
    {
        echo 'Підключення до БД створено'.PHP_EOL;
    }

    private function __clone() {}

    public function __wakeup(): void
    {
        throw new \LogicException(
            'Відновлення екземпляра Database заборонено'
        );
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}
