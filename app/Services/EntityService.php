<?php

declare(strict_types=1);

namespace {
    // Функції з попередніх лабораторних

    function calculateTourTotal(
        float $pricePerPerson,
        int $travelersCount
    ): float {
        return $pricePerPerson * $travelersCount;
    }

    function applyDiscount(
        float $price,
        float $discount
    ): float {
        if ($discount < 0 || $discount > 100) {
            throw new Exception(
                'Неприпустиме значення знижки!'
            );
        }

        return $price - ($price * ($discount / 100));
    }
}

namespace App\Services {
    use App\Interfaces\LoggerInterface;

    class EntityService
    {
        public function __construct(
            private LoggerInterface $logger
        ) {}

        public function calculateTourTotal(
            float $pricePerPerson,
            int $travelersCount
        ): float {
            $total = \calculateTourTotal(
                $pricePerPerson,
                $travelersCount
            );

            $this->logger->log(
                "Розраховано вартість туру: {$total} грн"
            );

            return $total;
        }

        public function applyDiscount(
            float $price,
            float $discount
        ): float {
            $result = \applyDiscount(
                $price,
                $discount
            );

            $this->logger->log(
                "Застосовано знижку {$discount}%. "
                ."Нова вартість: {$result} грн"
            );

            return $result;
        }
    }
}
