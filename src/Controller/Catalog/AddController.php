<?php

declare(strict_types=1);

namespace App\Controller\Catalog;

use App\DTO\Product;
use App\Messenger\Command\AddProductToCatalog;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/products", methods={"POST"}, name="product-add")
 */
final class AddController extends AbstractController
{
    public function __construct(
        private readonly ErrorBuilder $errorBuilder,
        private readonly MessageBusInterface $messageBus,
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator
    ) {
    }

    public function __invoke(Request $request)
    {
        try {
            $deserializeObject = $this->serializer->deserialize($request->getContent(), Product::class, 'json');
        } catch (MissingConstructorArgumentsException $argumentsException) {
            return new JsonResponse($this->errorBuilder->__invoke('Invalid request'), Response::HTTP_BAD_REQUEST);
        }

        $errors = $this->validator->validate($deserializeObject);
        if (count($errors) > 0) {
            return new JsonResponse($this->errorBuilder->__invoke(sprintf('%s - %s', $errors[0]->getPropertyPath(), $errors[0]->getMessage())), Response::HTTP_BAD_REQUEST);
        }

        $this->messageBus->dispatch(new AddProductToCatalog($deserializeObject->name, $deserializeObject->price, $deserializeObject->quantity));

        return new Response('', Response::HTTP_ACCEPTED);
    }
}
