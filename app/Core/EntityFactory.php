<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\AbstractEntity;
use App\Models\Booking;
use App\Models\Tour;
use InvalidArgumentException;

class EntityFactory
{
    public function createEntity(
        string $type,
        array $data
    ): AbstractEntity {
        return match ($type) {
            'tour' => new Tour(
                $data['id'],
                $data['createdAt'],
                $data['destination'],
                $data['price']
            ),

            'booking' => new Booking(
                $data['id'],
                $data['createdAt'],
                $data['customerName'],
                $data['tourId'],
                $data['travelers']
            ),

            default => throw new InvalidArgumentException(
                "Невідомий тип сутності: $type"
            ),
        };
    }
}
