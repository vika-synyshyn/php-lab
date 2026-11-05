<?php

declare(strict_types=1);

namespace App\Tasks;

class ShopManager extends Worker
{
    public function __construct(
        string $name,
        float $baseSalary
    ) {
        parent::__construct($name, $baseSalary);
    }

    public function calculateSalary(): float
    {
        return $this->baseSalary * 1.10;
    }

    public function getRoleDetails(): string
    {
        return sprintf(
            'Керівник цеху: %s, зарплата: %.2f грн',
            $this->name,
            $this->calculateSalary()
        );
    }
}
