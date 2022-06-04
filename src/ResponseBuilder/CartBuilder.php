<?php

declare(strict_types=1);

namespace App\ResponseBuilder;

use App\Service\Cart\Cart;

final class CartBuilder
{
    public function __invoke(Cart $cart): array
    {
        $data = [
            'total_price' => 0,
            'products' => []
        ];

        if ($cart->getProducts() > 0) {
            foreach ($cart->getProducts() as $product) {
                $data['products'][] = [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'created_at' => $product->getCreatedAt(),
                ];
            }
        }

        return $data;
    }
}
