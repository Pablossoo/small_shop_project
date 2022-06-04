<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\ProductCart;
use App\Exception\LimitProductCardExceededException;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Ramsey\Uuid\Uuid;

final class CartRepository implements CartService
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function addProduct(string $cartId, string $productId): void
    {
        $cart = $this->entityManager->find(Cart::class, $cartId);
        $product = $this->entityManager->find(Product::class, $productId);

        if ($cart->isFull()) {
            throw LimitProductCardExceededException::LimitProductCartExceeded($cartId);
        }

        if (!$product->isStockAvailable()) {
            throw new \Exception(sprintf('Product %s Out of stock!', $productId));
        }

        $productCart = new ProductCart(Uuid::uuid4()->toString());

        $cart->addProductCart($productCart);
        $product->addProductCart($productCart);

        $product->setQuantity($product->getQuantity() - 1);

        $this->entityManager->persist($productCart);
        $this->entityManager->flush();
    }

    public function removeProduct(string $cartId, string $productId): void
    {
        $cart = $this->entityManager->find(Cart::class, $cartId);
        $product = $this->entityManager->find(Product::class, $productId);
        $productCartRepository = $this->entityManager->getRepository(ProductCart::class);
        $productCart = $productCartRepository->findOneBy(['Cart' => $cart, 'Product' => $product]);

        if($productCart) {
            $cart->removeProductCart($productCart);
            $this->entityManager->persist($cart);
            $this->entityManager->flush();
        }
    }

    public function create(): void
    {
        $cart = new Cart(Uuid::uuid4()->toString());

        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }

    public function getLastCreatedCart(): string
    {
        return $this->entityManager->getRepository(Cart::class)
            ->createQueryBuilder('c')
            ->select('c.id')
            ->orderBy('c.createdAt', 'desc')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
