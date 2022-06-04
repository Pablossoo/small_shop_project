<?php

declare(strict_types=1);

namespace App\Messenger\Command;

final class RemoveProductFromCatalog
{
    public function __construct(public readonly string $productId)
    {
    }
}
