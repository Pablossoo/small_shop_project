<?php

declare(strict_types=1);

namespace App\Service\Cart;

interface Cart
{
    public function getId(): string;
    public function isFull(): bool;
    public function getTotalPrice(): int;
    public function getProducts(): array;

}
