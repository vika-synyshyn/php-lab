<?php

declare(strict_types=1);

namespace Tests;

use App\Models\Tour;

require_once __DIR__.'/../vendor/autoload.php';

$tour = new Tour(
    'T001',
    '2026-11-05',
    'Карпати',
    12000.00
);

echo "Інформація про тур:\n";
echo $tour->getDetails().PHP_EOL;

echo "\nЕкспорт туру в JSON:\n";
echo $tour->exportToJson().PHP_EOL;
