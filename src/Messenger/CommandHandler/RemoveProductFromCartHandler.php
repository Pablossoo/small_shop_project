<?php

declare(strict_types=1);

namespace App\Messenger\CommandHandler;

use App\Messenger\Command\RemoveProductFromCart;
use App\Service\Cart\CartService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class RemoveProductFromCartHandler implements MessageHandlerInterface
{
    public function __construct(private CartService $service)
    {
    }

    public function __invoke(RemoveProductFromCart $command): void
    {
        $this->service->removeProduct($command->cartId, $command->productId);
    }
}
