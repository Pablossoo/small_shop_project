<?php

declare(strict_types=1);

namespace App\Messenger\Command;

final class AddProductToCatalog
{
    public function __construct(
        public readonly string $name,
        public readonly int $price,
        public readonly int $quantity
    ) {
    }
}
