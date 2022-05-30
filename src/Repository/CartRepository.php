<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Product;
use App\Entity\ProductCart;
use App\Exception\LimitProductCardExceededException;
use App\Service\Cart\Cart;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

final class CartRepository implements CartService
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function addProduct(string $cartId, string $productId): void
    {
        $cart    = $this->entityManager->find(\App\Entity\Cart::class, $cartId);
        $product = $this->entityManager->find(Product::class, $productId);

        $productCart = new ProductCart(Uuid::uuid4()->toString());
        $productCart->setCart($cart);
        $productCart->setProduct($product);

        if ($cart->isFull()) {
            throw LimitProductCardExceededException::LimitProductCartExceeded($cartId);
        }

        $this->entityManager->persist($productCart);
        $this->entityManager->flush();
    }

    public function removeProduct(string $cartId, string $productId): void
    {
        $cart    = $this->entityManager->find(\App\Entity\Cart::class, $cartId);
        $product = $this->entityManager->find(Product::class, $productId);

        if ($cart && $product && $cart->hasProduct($product)) {
            $cart->removeProduct($product);
            $this->entityManager->persist($cart);
            $this->entityManager->flush();
        }
    }

    public function create(): Cart
    {
        $cart = new \App\Entity\Cart(Uuid::uuid4()->toString());

        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $cart;
    }

    public function updateProductQuantity(string $productId): void
    {
        $product = $this->entityManager->find(Product::class, $productId);

        if (! $product->isStockAvailable()) {
            throw new \Exception(sprintf('Product %s Out of stock!', $productId));
        }
        $product->setQuantity($product->getQuantity()-1);
        $this->entityManager->flush();
    }
}
