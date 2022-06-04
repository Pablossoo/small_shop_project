<?php

declare(strict_types=1);

namespace App\Messenger\CommandHandler;

use App\Messenger\Command\AddProductToCart;
use App\Service\Cart\CartService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class AddProductToCartHandler
{
    public function __construct(private CartService $service)
    {
    }

    public function __invoke(AddProductToCart $command): void
    {
        $this->service->addProduct($command->cartId, $command->productId);
    }
}
