<?php

declare(strict_types=1);

namespace App\Tasks;

class Student
{
    public function __construct(
        private readonly int $id,
        private readonly string $name,
        private readonly string $surname,
        private readonly string $birthday
    ) {}

    public function getId(): int
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->name.' '.$this->surname;
    }

    public function getDetails(): string
    {
        return sprintf(
            'Студент #%d: %s %s, дата народження: %s',
            $this->id,
            $this->name,
            $this->surname,
            $this->birthday
        );
    }
}
