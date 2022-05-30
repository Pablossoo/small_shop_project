<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Entity\Cart;
use App\Entity\Product;
use App\Messenger\Command\RemoveProductFromCart;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart/{cart}/{product}", methods={"DELETE"}, name="cart-remove-product")
 */
final class RemoveProductController extends AbstractController
{
    public function __construct(
        private readonly ErrorBuilder $errorBuilder,
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function __invoke(Cart $cart, ?Product $product): Response
    {
        if ($product !== null) {
            $this->messageBus->dispatch(new RemoveProductFromCart($cart->getId(), $product->getId()));
        }

        return new Response('', Response::HTTP_ACCEPTED);
    }
}
