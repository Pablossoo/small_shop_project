<?php

declare(strict_types=1);

namespace App\ResponseBuilder;

use App\Service\Cart\Cart;

final class CartBuilder
{
    public function __invoke(Cart $cart): array
    {
        $data = [
            'total_price' => $cart->getTotalPrice(),
            'products' => []
        ];


        if ($cart->getProducts() > 0) {

            foreach ($cart->getProducts() as $product) {
                $data['products'][] = [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'price' => $product->getPrice(),
                    'quantity' => $product->getQuantity(),
                    'created_at' => $product->getCreatedAt()->format('Y-m-d H:i:s'),
                ];
            }
        }

        return $data;
    }
}
