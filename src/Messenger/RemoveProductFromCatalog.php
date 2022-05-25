<?php

declare(strict_types=1);

namespace App\Messenger;

final class RemoveProductFromCatalog
{
    public function __construct(public readonly string $productId)
    {
    }
}
