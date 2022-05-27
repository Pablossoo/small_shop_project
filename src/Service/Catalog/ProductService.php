<?php

declare(strict_types=1);

namespace App\Service\Catalog;

interface ProductService
{
    public function add(string $name, int $price, int $quantity): Product;

    public function remove(string $id): void;
}
