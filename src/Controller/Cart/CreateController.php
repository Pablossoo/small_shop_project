<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Messenger\Command\CreateCart;
use App\Service\Cart\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart", methods={"POST"}, name="cart-create")
 */
final class CreateController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function __invoke(): Response
    {
        /** @var Cart $cart */
        $cart = $this->messageBus->dispatch(new CreateCart());

        return new JsonResponse([
            'cart_id' => $cart->getId(),
        ], Response::HTTP_CREATED);
    }
}
