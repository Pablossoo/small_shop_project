<?php

declare(strict_types=1);

namespace App\Messenger\CommandHandler;

use App\Messenger\Command\AddProductToCatalog;
use App\Service\Catalog\ProductService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]final class AddProductToCatalogHandler
{
    public function __construct(private readonly ProductService $service)
    {
    }

    public function __invoke(AddProductToCatalog $command): void
    {
        $this->service->add($command->name, $command->price, $command->quantity);
    }
}
