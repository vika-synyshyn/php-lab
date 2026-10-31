<?php

declare(strict_types=1);
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

$numbers = [9, 4, 7, 2, 8, 3];
$arrayResult = findGreaterThanRightNeighbor($numbers);

$inputText = 'Туристи подорожують до Італії';
$swappedText = swapFirstAndLastWord($inputText);

$numberString = '120 850 430 1500 670';
$maxNumber = findMaxNumber($numberString);

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Розрахунок вартості туру</title>
</head>
<body>
    <h1>Електронна система туристичного оператора</h1>

    <h2>Розрахунок вартості бронювання</h2>

    <p>Вартість на одну особу: <?= $pricePerPerson ?> EUR</p>
    <p>Кількість туристів: <?= $travelersCount ?></p>

    <p>
        <strong>
            Загальна вартість:
            <?= $totalPrice ?> EUR
        </strong>
    </p>

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

<h2>Обробка винятків під час застосування знижки</h2>

<?php
try {
    $discountedPrice = applyDiscount(1000.0, 150.0);

    echo "<p>Вартість після знижки: $discountedPrice EUR</p>";
} catch (Exception $e) {
    echo '<p>Помилка: '.htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8').'</p>';
} finally {
    echo '<p>Завершення спроби розрахунку.</p>';
}
?>

<h2>Індивідуальні алгоритмічні завдання — варіант 18</h2>

<h3>Завдання 1. Порівняння сусідніх елементів масиву</h3>

<p>Початковий масив: <?= implode(', ', $numbers) ?></p>
<p>Індекси знайдених елементів:
    <?= implode(', ', $arrayResult['indices']) ?>
</p>
<p>Кількість елементів: <?= $arrayResult['count'] ?></p>

<h3>Завдання 2. Перестановка першого та останнього слова</h3>

<p>Початковий рядок:
    <?= htmlspecialchars($inputText, ENT_QUOTES, 'UTF-8') ?>
</p>
<p>Результат:
    <?= htmlspecialchars($swappedText, ENT_QUOTES, 'UTF-8') ?>
</p>

<h3>Завдання 3. Пошук максимального числа</h3>

<p>Початковий рядок:
    <?= htmlspecialchars($numberString, ENT_QUOTES, 'UTF-8') ?>
</p>
<p>Максимальне число: <?= $maxNumber ?></p>
cd php-lab
</body>
</html>
