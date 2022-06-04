<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Cart\AddProductController;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\ProductCart;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class AddProductControllerFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            new Product('fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7', 'Product 1', 1990, 1),
            new Product('9670ea5b-d940-4593-a2ac-4589be784203', 'Product 2', 3990, 2),
        ];

        $cart = new Cart('5bd88887-7017-4c08-83de-8b5d9abde58c');
        $manager->persist($cart);

        foreach ($products as $product) {
            $fullCart = new ProductCart(Uuid::uuid4()->toString());

            $fullCart->setCart($cart);
            $fullCart->setProduct($product);
            $manager->persist($fullCart);
            $manager->persist($product);

        }
        $manager->flush();
    }
}
