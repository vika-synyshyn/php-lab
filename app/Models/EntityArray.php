<?php

$tourTitles = [
    'Відпочинок у Греції',
    'Подорож до Рима',
    'Альпійський вікенд',
    'Тур Карпатами',
    'Круїз Середземним морем',
];

sort($tourTitles, SORT_STRING);

$tour = [
    'id' => 1,
    'manager_id' => 3,
    'category_id' => 2,
    'destination_id' => 5,
    'title' => 'Альпійський вікенд',
    'status' => 'published',
];
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Туристична система — Масиви PHP</title>
</head>
<body>
    <h1>Електронна система туристичного оператора</h1>

    <h2>1. Список туристичних турів</h2>
    <ul>
        <?php foreach ($tourTitles as $title) { ?>
            <li><?= htmlspecialchars($title, ENT_QUOTES, 'UTF-8') ?></li>
        <?php } ?>
    </ul>

    <h2>2. Інформація про тур</h2>
    <ul>
        <?php foreach ($tour as $key => $value) { ?>
            <li>
                <strong><?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>:</strong>
                <?= htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8') ?>
            </li>
        <?php } ?>
    </ul>
</body>
</html>
