<?php

declare(strict_types=1);

namespace App\Controller\Cart;

use App\Entity\Cart;
use App\Entity\Product;
use App\Messenger\Command\AddProductToCart;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart/{cart}/{product}", methods={"POST"}, name="cart-add-product")
 */
final class AddProductController extends AbstractController
{
    public function __construct(
        private readonly ErrorBuilder $errorBuilder,
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function __invoke(Cart $cart, Product $product): Response
    {
        try {
            $this->messageBus->dispatch(new AddProductToCart($cart->getId(), $product->getId()));
        } catch (\Throwable $exception) {
            return new JsonResponse($this->errorBuilder->__invoke($exception->getPrevious()->getMessage()), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new JsonResponse('success', Response::HTTP_ACCEPTED);
    }
}
