<?php

declare(strict_types=1);

namespace App\Tasks;

use InvalidArgumentException;

abstract class Worker
{
    public function __construct(
        protected readonly string $name,
        protected readonly float $baseSalary
    ) {
        if ($baseSalary < 0) {
            throw new InvalidArgumentException(
                'Заробітна плата не може бути від’ємною'
            );
        }
    }

    abstract public function calculateSalary(): float;

    public function getName(): string
    {
        return $this->name;
    }
}
