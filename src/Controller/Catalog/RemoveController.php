<?php

declare(strict_types=1);

namespace App\Controller\Catalog;

use App\Entity\Product;
use App\Messenger\Command\RemoveProductFromCatalog;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products/{product}", methods={"DELETE"}, name="product-delete")
 */
final class RemoveController extends AbstractController
{
    public function __construct(
        private readonly ErrorBuilder $errorBuilder,
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function __invoke(?Product $product): Response
    {
        if ($product !== null) {
            $this->messageBus->dispatch(new RemoveProductFromCatalog($product->getId()));
        }

        return new Response('', Response::HTTP_ACCEPTED);
    }
}
