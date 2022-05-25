<?php

declare(strict_types=1);

namespace App\Messenger;

final class AddProductToCart
{
    public function __construct(
        public readonly string $cartId,
        public readonly string $productId
    ) {
    }
}
