<?php

declare(strict_types=1);

namespace App\Tasks;

class CompanyManager extends DepartmentHead
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
            + ($this->baseSalary * 0.25);
    }

    public function getRoleDetails(): string
    {
        return sprintf(
            'Керівник підприємства: %s, зарплата: %.2f грн',
            $this->name,
            $this->calculateSalary()
        );
    }
}
