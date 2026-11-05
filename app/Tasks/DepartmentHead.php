<?php

declare(strict_types=1);

namespace App\Tasks;

class DepartmentHead extends ShopManager
{
    public function __construct(
        string $name,
        float $baseSalary
    ) {
        parent::__construct($name, $baseSalary);
    }

    public function calculateSalary(): float
    {
        return parent::calculateSalary()
            + ($this->baseSalary * 0.15);
    }

    public function getRoleDetails(): string
    {
        return sprintf(
            'Начальник відділу: %s, зарплата: %.2f грн',
            $this->name,
            $this->calculateSalary()
        );
    }
}
