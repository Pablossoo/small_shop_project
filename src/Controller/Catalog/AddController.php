<?php

declare(strict_types=1);

namespace App\Controller\Catalog;

use App\Messenger\Command\AddProductToCatalog;
use App\RequestValidatorContract;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products", methods={"POST"}, name="product-add")
 */
final class AddController extends AbstractController
{
    public function __construct(
        private readonly ErrorBuilder             $errorBuilder,
        private readonly RequestValidatorContract $requestValidatorContract,
        private readonly MessageBusInterface      $messageBus
    )
    {
    }

    public function __invoke(Request $request)
    {
        $parameters = json_decode($request->getContent(), true);

        if (!$this->requestValidatorContract->validate($parameters)) {
            return new JsonResponse($this->errorBuilder->__invoke('Invalid parameters'), Response::HTTP_BAD_REQUEST);
        }

        $name = trim($parameters['name']);
        $price = $parameters['price'];
        $quantity = $parameters['quantity'];

        $this->messageBus->dispatch(new AddProductToCatalog($name, $price, $quantity));

        return new Response('', Response::HTTP_ACCEPTED);
    }
}
