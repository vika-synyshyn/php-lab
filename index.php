<?php

declare(strict_types=1);

use App\Core\Database;
use App\Core\EntityFactory;
use App\Interfaces\ExportableInterface;
use App\Services\ConsoleLogger;
use App\Services\EntityService;
use App\Tasks\CompanyManager;
use App\Tasks\DepartmentHead;
use App\Tasks\Group;
use App\Tasks\ShopManager;
use App\Tasks\SquareMatrix;
use App\Tasks\Student;
use Faker\Factory;

require_once __DIR__.'/app/Services/EntityService.php';
require_once __DIR__.'/app/Services/DataProcessor.php';
require_once __DIR__.'/vendor/autoload.php';

$pricePerPerson = 850.0;
$travelersCount = 3;

$totalPrice = calculateTourTotal(
    $pricePerPerson,
    $travelersCount
);

// Генерація тестових даних Faker
$faker = Factory::create();

$tourPrices = [];

for ($i = 0; $i < 10; $i++) {
    $tourPrices[] = $faker->numberBetween(300, 3000);
}

$minThreshold = 1000;

$filteredPrices = array_filter(
    $tourPrices,
    function (int $price) use ($minThreshold): bool {
        return $price > $minThreshold;
    }
);

// Індивідуальні алгоритмічні завдання
$numbers = [9, 4, 7, 2, 8, 3];
$arrayResult = findGreaterThanRightNeighbor($numbers);

$inputText = 'Туристи подорожують до Італії';
$swappedText = swapFirstAndLastWord($inputText);

$numberString = '120 850 430 1500 670';
$maxNumber = findMaxNumber($numberString);

// ========================================
// ЛАБОРАТОРНА РОБОТА №4
// ========================================

// 1. Патерн Singleton
ob_start();

$db1 = Database::getInstance();
$db2 = Database::getInstance();

$databaseMessage = ob_get_clean();
$isSingleton = $db1 === $db2;

// 2. Патерн Factory
$factory = new EntityFactory;

$tour = $factory->createEntity('tour', [
    'id' => 'T003',
    'createdAt' => '2026-11-05',
    'destination' => 'Іспанія',
    'price' => 32000.00,
]);

$booking = $factory->createEntity('booking', [
    'id' => 'B002',
    'createdAt' => '2026-11-05',
    'customerName' => 'Марія Іваненко',
    'tourId' => 'T003',
    'travelers' => 2,
]);

// 3. Інтерфейс і трейт
if (! ($tour instanceof ExportableInterface)) {
    throw new LogicException(
        'Обʼєкт туру не підтримує експорт у JSON'
    );
}

$tourJson = $tour->exportToJson();

// 4. Dependency Injection
$logger = new ConsoleLogger;
$entityService = new EntityService($logger);

ob_start();

$serviceTotal = $entityService->calculateTourTotal(
    5000.0,
    3
);

$serviceDiscounted = $entityService->applyDiscount(
    $serviceTotal,
    10.0
);

$consoleOutput = ob_get_clean();

// ========================================
// ІНДИВІДУАЛЬНІ ЗАВДАННЯ — ВАРІАНТ 18
// ========================================

// Завдання 1. Композиція класів Student і Group

$demoGroup = new Group(32, 'КН-32');

$student1 = new Student(
    1,
    'Олена',
    'Петренко',
    '2004-05-12'
);

$student2 = new Student(
    2,
    'Іван',
    'Коваль',
    '2003-09-20'
);

$student3 = new Student(
    3,
    'Марія',
    'Мельник',
    '2004-02-15'
);

$demoGroup->addStudent($student1);
$demoGroup->addStudent($student2);
$demoGroup->addStudent($student3);

// Стан групи після додавання
$initialGroupDetails = $demoGroup->getDetails();
$initialStudents = $demoGroup->getStudents();

// Пошук студента
$foundStudent = $demoGroup->searchStudent('Іван Коваль');

// Видалення студента
$removedStudent = $demoGroup->removeStudent(1);

// Перевірка результату видалення
$remainingStudents = $demoGroup->getStudents();

$isStudentDeleted = (
    $demoGroup->searchStudent('Олена Петренко') === null
);

// Завдання 2. Ієрархія працівників

$demoEmployees = [
    new ShopManager('Іван Петренко', 20000.0),
    new DepartmentHead('Олена Коваль', 20000.0),
    new CompanyManager('Марія Мельник', 20000.0),
];

$expectedSalaries = [
    22000.0,
    25000.0,
    30000.0,
];

// Завдання 3. Квадратна матриця 3x3

$demoMatrix = new SquareMatrix([
    [2, 1, 3],
    [0, 4, 5],
    [1, 2, 6],
]);

$diagonalSum = $demoMatrix->calculateDiagonalSum();
$determinant = $demoMatrix->calculateDeterminant();

$isDiagonalCorrect = abs($diagonalSum - 12) < 0.000001;
$isDeterminantCorrect = abs($determinant - 21) < 0.000001;

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Електронна система туристичного оператора</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        h1 {
            color: #17365d;
        }

        h2 {
            color: #254b78;
            margin-top: 35px;
        }

        h3 {
            margin-top: 25px;
        }

        section {
            margin-bottom: 30px;
        }

        pre {
            background: #f4f6f8;
            padding: 15px;
            border-radius: 6px;
            overflow-x: auto;
        }

        table {
            border-collapse: collapse;
            margin: 15px 0;
        }

        th, td {
            border: 1px solid #b8c3cf;
            padding: 10px 15px;
            text-align: left;
        }

        th {
            background: #e9eef5;
        }

        .matrix td {
            text-align: center;
            min-width: 45px;
        }

        .success {
            color: #16703c;
            font-weight: bold;
        }

        .error {
            color: #b42318;
            font-weight: bold;
        }

        hr {
            margin: 40px 0;
            border: 0;
            border-top: 1px solid #ccc;
        }
    </style>
</head>

<body>

<h1>Електронна система туристичного оператора</h1>

<!-- =================================== -->
<!-- ПОПЕРЕДНІ ЛАБОРАТОРНІ РОБОТИ        -->
<!-- =================================== -->

<section>
    <h2>Розрахунок вартості бронювання</h2>

    <p>
        Вартість на одну особу:
        <?= $pricePerPerson ?> EUR
    </p>

    <p>
        Кількість туристів:
        <?= $travelersCount ?>
    </p>

    <p>
        <strong>
            Загальна вартість:
            <?= $totalPrice ?> EUR
        </strong>
    </p>
</section>

<section>
    <h2>Генерація тестових цін турів (Faker)</h2>

    <h3>Усі згенеровані ціни:</h3>

    <ul>
        <?php foreach ($tourPrices as $price) { ?>
            <li><?= $price ?> EUR</li>
        <?php } ?>
    </ul>

    <h3>Тури дорожчі за <?= $minThreshold ?> EUR:</h3>

    <ul>
        <?php foreach ($filteredPrices as $price) { ?>
            <li><?= $price ?> EUR</li>
        <?php } ?>
    </ul>
</section>

<section>
    <h2>Обробка винятків під час застосування знижки</h2>

    <?php
    try {
        $discountedPrice = applyDiscount(1000.0, 150.0);

        echo "<p>Вартість після знижки: $discountedPrice EUR</p>";
    } catch (Exception $e) {
        echo '<p>Помилка: '
            .htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8')
            .'</p>';
    } finally {
        echo '<p>Завершення спроби розрахунку.</p>';
    }
?>
</section>

<section>
    <h2>Індивідуальні алгоритмічні завдання — варіант 18</h2>

    <h3>Завдання 1. Порівняння сусідніх елементів масиву</h3>

    <p>
        Початковий масив:
        <?= implode(', ', $numbers) ?>
    </p>

    <p>
        Індекси знайдених елементів:
        <?= implode(', ', $arrayResult['indices']) ?>
    </p>

    <p>
        Кількість елементів:
        <?= $arrayResult['count'] ?>
    </p>

    <h3>Завдання 2. Перестановка першого та останнього слова</h3>

    <p>
        Початковий рядок:
        <?= htmlspecialchars($inputText, ENT_QUOTES, 'UTF-8') ?>
    </p>

    <p>
        Результат:
        <?= htmlspecialchars($swappedText, ENT_QUOTES, 'UTF-8') ?>
    </p>

    <h3>Завдання 3. Пошук максимального числа</h3>

    <p>
        Початковий рядок:
        <?= htmlspecialchars($numberString, ENT_QUOTES, 'UTF-8') ?>
    </p>

    <p>
        Максимальне число:
        <?= $maxNumber ?>
    </p>
</section>

<hr>

<!-- =================================== -->
<!-- ЛАБОРАТОРНА РОБОТА №4               -->
<!-- =================================== -->

<h2>Лабораторна робота №4 — ООП та патерни проєктування</h2>

<section>
    <h3>1. Патерн Singleton</h3>

    <pre><?= htmlspecialchars($databaseMessage, ENT_QUOTES, 'UTF-8') ?></pre>

    <p>
        Результат перевірки:
        <strong class="<?= $isSingleton ? 'success' : 'error' ?>">
            <?= $isSingleton
            ? 'Використовується один екземпляр Database'
            : 'Помилка реалізації Singleton' ?>
        </strong>
    </p>
</section>

<section>
    <h3>2. Патерн Factory та наслідування</h3>

    <h4>Створений туристичний тур</h4>

    <p>
        <?= htmlspecialchars($tour->getDetails(), ENT_QUOTES, 'UTF-8') ?>
    </p>

    <h4>Створене бронювання</h4>

    <p>
        <?= htmlspecialchars($booking->getDetails(), ENT_QUOTES, 'UTF-8') ?>
    </p>
</section>

<section>
    <h3>3. Експорт туру в JSON</h3>

    <pre><?= htmlspecialchars($tourJson, ENT_QUOTES, 'UTF-8') ?></pre>
</section>

<section>
    <h3>4. Dependency Injection</h3>

    <h4>Логування через ConsoleLogger</h4>

    <pre><?= htmlspecialchars($consoleOutput, ENT_QUOTES, 'UTF-8') ?></pre>

    <p>
        <strong>
            Підсумкова вартість зі знижкою:
            <?= $serviceDiscounted ?> грн
        </strong>
    </p>
</section>

<hr>

<!-- =================================== -->
<!-- ІНДИВІДУАЛЬНІ ЗАВДАННЯ №4           -->
<!-- =================================== -->

<h2>Індивідуальні архітектурні завдання — варіант 18</h2>

<!-- ЗАВДАННЯ 1 -->

<section>
    <h3>Завдання 1. Композиція класів Student і Group</h3>

    <h4>1.1. Додавання студентів до групи</h4>

    <p>
        <?= htmlspecialchars($initialGroupDetails, ENT_QUOTES, 'UTF-8') ?>
    </p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>ПІБ студента</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($initialStudents as $student) { ?>
                <tr>
                    <td><?= $student->getId() ?></td>
                    <td>
                        <?= htmlspecialchars(
                            $student->getFullName(),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h4>1.2. Пошук студента</h4>

    <p>
        Результат:
        <?php if ($foundStudent !== null) { ?>
            <span class="success">
                <?= htmlspecialchars(
                    $foundStudent->getDetails(),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>
            </span>
        <?php } else { ?>
            <span class="error">Студента не знайдено</span>
        <?php } ?>
    </p>

    <h4>1.3. Видалення студента</h4>

    <p>
        <?= $removedStudent
            ? 'Студента з ID 1 успішно видалено'
            : 'Студента не знайдено' ?>
    </p>

    <p>
        Кількість студентів після видалення:
        <strong><?= count($remainingStudents) ?></strong>
    </p>

    <p class="<?= $isStudentDeleted ? 'success' : 'error' ?>">
        <?= $isStudentDeleted
            ? 'Перевірка успішна: видалений студент відсутній у групі'
            : 'Помилка: студент залишився у групі' ?>
    </p>
</section>

<!-- ЗАВДАННЯ 2 -->

<section>
    <h3>Завдання 2. Ієрархія працівників</h3>

    <p>
        Реалізовано багаторівневе наслідування класів:
        Worker → ShopManager → DepartmentHead → CompanyManager.
    </p>

    <h4>2.1. Розрахунок заробітної плати</h4>

    <table>
        <thead>
            <tr>
                <th>Посада та працівник</th>
                <th>Заробітна плата</th>
                <th>Перевірка</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($demoEmployees as $index => $employee) { ?>
                <?php
                $salary = $employee->calculateSalary();

                $isCorrect = abs(
                    $salary - $expectedSalaries[$index]
                ) < 0.001;
                ?>
                <tr>
                    <td>
                        <?= htmlspecialchars(
                            $employee->getRoleDetails(),
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>

                    <td>
                        <?= number_format($salary, 2, '.', ' ') ?> грн
                    </td>

                    <td class="<?= $isCorrect ? 'success' : 'error' ?>">
                        <?= $isCorrect ? 'Правильно' : 'Помилка' ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h4>2.2. Перевірка поліморфізму</h4>

    <p>
        Метод calculateSalary() перевизначений у кожному
        дочірньому класі та повертає відповідний результат.
    </p>

    <ul>
        <?php foreach ($demoEmployees as $index => $employee) { ?>
            <li>
                Працівник <?= $index + 1 ?>:
                <strong class="<?= abs(
                    $employee->calculateSalary()
                    - $expectedSalaries[$index]
                ) < 0.001 ? 'success' : 'error'
            ?>">
                    <?= abs(
                        $employee->calculateSalary()
                        - $expectedSalaries[$index]
                    ) < 0.001
                        ? 'Розрахунок правильний'
                        : 'Помилка розрахунку'
            ?>
                </strong>
            </li>
        <?php } ?>
    </ul>
</section>

<!-- ЗАВДАННЯ 3 -->

<section>
    <h3>Завдання 3. Клас SquareMatrix</h3>

    <h4>3.1. Початкова матриця 3×3</h4>

    <table class="matrix">
        <tbody>
            <?php foreach ($demoMatrix->getMatrix() as $row) { ?>
                <tr>
                    <?php foreach ($row as $value) { ?>
                        <td><?= $value ?></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h4>3.2. Сума головної діагоналі</h4>

    <p>
        Формула:
        <strong>S = a₁₁ + a₂₂ + a₃₃</strong>
    </p>

    <p>
        Результат:
        <strong><?= $diagonalSum ?></strong>
    </p>

    <p class="<?= $isDiagonalCorrect ? 'success' : 'error' ?>">
        <?= $isDiagonalCorrect
            ? 'Розрахунок суми діагоналі правильний'
            : 'Помилка розрахунку суми діагоналі' ?>
    </p>

    <h4>3.3. Визначник матриці</h4>

    <p>
        Результат:
        <strong><?= $determinant ?></strong>
    </p>

    <p class="<?= $isDeterminantCorrect ? 'success' : 'error' ?>">
        <?= $isDeterminantCorrect
            ? 'Розрахунок визначника правильний'
            : 'Помилка розрахунку визначника' ?>
    </p>
</section>


</body>
</html>
