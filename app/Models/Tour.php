<?php

declare(strict_types=1);

namespace App\Models;

use App\Interfaces\ExportableInterface;
use App\Traits\JsonExportTrait;

class Tour extends AbstractEntity implements ExportableInterface
{
    use JsonExportTrait;

    public function __construct(
        string $id,
        string $createdAt,
        private string $destination,
        private float $price
    ) {
        parent::__construct($id, $createdAt);
    }

    public function getDetails(): string
    {
        return sprintf(
            'Тур #%s: %s, ціна: %.2f грн',
            $this->id,
            $this->destination,
            $this->price
        );
    }
}
