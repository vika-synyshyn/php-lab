<?php

declare(strict_types=1);

namespace App\Models;

class Booking extends AbstractEntity
{
    public function __construct(
        string $id,
        string $createdAt,
        private string $customerName,
        private string $tourId,
        private int $travelers
    ) {
        parent::__construct($id, $createdAt);
    }

    public function getDetails(): string
    {
        return sprintf(
            'Бронювання #%s: клієнт %s, тур #%s, туристів: %d',
            $this->id,
            $this->customerName,
            $this->tourId,
            $this->travelers
        );
    }
}
