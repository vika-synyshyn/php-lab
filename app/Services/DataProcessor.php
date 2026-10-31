<?php

declare(strict_types=1);

function findGreaterThanRightNeighbor(array $numbers): array
{
    $indices = [];

    for ($i = 0; $i < count($numbers) - 1; $i++) {
        if ($numbers[$i] > $numbers[$i + 1]) {
            $indices[] = $i;
        }
    }

    return [
        'indices' => $indices,
        'count' => count($indices),
    ];
}

function swapFirstAndLastWord(string $text): string
{
    $words = preg_split('/\s+/u', trim($text));

    if (count($words) < 2) {
        return $text;
    }

    $lastIndex = count($words) - 1;

    [$words[0], $words[$lastIndex]] =
        [$words[$lastIndex], $words[0]];

    return implode(' ', $words);
}

function findMaxNumber(string $input): float
{
    if (trim($input) === '') {
        throw new InvalidArgumentException('Рядок не може бути порожнім.');
    }

    $values = preg_split('/\s+/', trim($input));

    foreach ($values as $value) {
        if (! is_numeric($value)) {
            throw new InvalidArgumentException('Рядок повинен містити лише числа.');
        }
    }

    $numbers = array_map('floatval', $values);

    return max($numbers);
}
