<?php

declare(strict_types=1);

namespace App\Tasks;

use InvalidArgumentException;

class SquareMatrix
{
    public function __construct(
        private readonly array $matrix
    ) {
        if (count($matrix) !== 3 || ! array_is_list($matrix)) {
            throw new InvalidArgumentException(
                'Матриця повинна мати розмір 3x3'
            );
        }

        foreach ($matrix as $row) {
            if (
                ! is_array($row) ||
                count($row) !== 3 ||
                ! array_is_list($row)
            ) {
                throw new InvalidArgumentException(
                    'Кожен рядок повинен містити 3 елементи'
                );
            }

            foreach ($row as $value) {
                if (! is_int($value) && ! is_float($value)) {
                    throw new InvalidArgumentException(
                        'Елементи матриці повинні бути числами'
                    );
                }
            }
        }
    }

    public function calculateDiagonalSum(): float
    {
        return $this->matrix[0][0]
            + $this->matrix[1][1]
            + $this->matrix[2][2];
    }

    public function calculateDeterminant(): float
    {
        $a = $this->matrix;

        return $a[0][0] * (
            $a[1][1] * $a[2][2] -
            $a[1][2] * $a[2][1]
        )
        - $a[0][1] * (
            $a[1][0] * $a[2][2] -
            $a[1][2] * $a[2][0]
        )
        + $a[0][2] * (
            $a[1][0] * $a[2][1] -
            $a[1][1] * $a[2][0]
        );
    }

    public function getMatrix(): array
    {
        return $this->matrix;
    }
}
