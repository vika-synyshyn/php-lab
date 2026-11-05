<?php

declare(strict_types=1);

namespace App\Tasks;

class Group
{
    /** @var array<int, Student> */
    private array $students = [];

    public function __construct(
        private readonly int $groupId,
        private readonly string $name
    ) {}

    public function addStudent(Student $student): void
    {
        $this->students[$student->getId()] = $student;
    }

    public function removeStudent(int $id): bool
    {
        if (! isset($this->students[$id])) {
            return false;
        }

        unset($this->students[$id]);

        return true;
    }

    public function searchStudent(string $fullName): ?Student
    {
        foreach ($this->students as $student) {
            if ($student->getFullName() === $fullName) {
                return $student;
            }
        }

        return null;
    }

    public function getStudents(): array
    {
        return array_values($this->students);
    }

    public function getDetails(): string
    {
        return sprintf(
            'Група #%d: %s, кількість студентів: %d',
            $this->groupId,
            $this->name,
            count($this->students)
        );
    }
}
