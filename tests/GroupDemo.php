<?php

declare(strict_types=1);

namespace Tests;

use App\Tasks\Group;
use App\Tasks\Student;

require_once __DIR__.'/../vendor/autoload.php';

echo 'Перевірка композиції класів Student і Group:'.PHP_EOL;

// Створення студентів
$student1 = new Student(1, 'Олена', 'Петренко', '2004-05-12');
$student2 = new Student(2, 'Іван', 'Коваль', '2003-09-20');
$student3 = new Student(3, 'Марія', 'Мельник', '2004-02-15');

// Створення групи
$group = new Group(32, 'КН-32');

// Додавання студентів
$group->addStudent($student1);
$group->addStudent($student2);
$group->addStudent($student3);

echo PHP_EOL.'1. Додавання студентів:'.PHP_EOL;
echo $group->getDetails().PHP_EOL;

foreach ($group->getStudents() as $student) {
    echo $student->getDetails().PHP_EOL;
}

// Пошук студента
echo PHP_EOL.'2. Пошук студента:'.PHP_EOL;

$found = $group->searchStudent('Іван Коваль');

if ($found !== null) {
    echo 'Знайдено: '.$found->getDetails().PHP_EOL;
} else {
    echo 'Студента не знайдено'.PHP_EOL;
}

// Видалення студента
echo PHP_EOL.'3. Видалення студента:'.PHP_EOL;

$removed = $group->removeStudent(1);

echo $removed
    ? 'Студента з ID 1 видалено'.PHP_EOL
    : 'Студента не знайдено'.PHP_EOL;

echo $group->getDetails().PHP_EOL;

// Перевірка після видалення
echo PHP_EOL.'4. Перевірка після видалення:'.PHP_EOL;

$deletedStudent = $group->searchStudent('Олена Петренко');

if ($deletedStudent === null) {
    echo 'Видалений студент відсутній у групі'.PHP_EOL;
} else {
    echo 'Помилка: студент залишився у групі'.PHP_EOL;
}
