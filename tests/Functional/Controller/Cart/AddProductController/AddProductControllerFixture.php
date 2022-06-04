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
            new Product('fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7', 'Product 1', 1990, 12),
            new Product('00e91390-3af8-4735-bd06-0311e7131757', 'Product 22', 1990, 3),
            new Product('15e4a636-ef98-445b-86df-46e1cc0e10b5', 'Product 3', 4990, 3),
        ];

        foreach ($products as $product) {
            $manager->persist($product);
        }

        $cart = new Cart('5bd88887-7017-4c08-83de-8b5d9abde58c');
        $cart2 = new Cart('1e82de36-23f3-4ae7-ad5d-616295f1d6c0');

        $productCart = new ProductCart(Uuid::uuid4()->toString());
        $products[0]->addProductCart($productCart);
        $cart2->addProductCart($productCart);


        $productCart1 = new ProductCart(Uuid::uuid4()->toString());
        $productCart2 = new ProductCart(Uuid::uuid4()->toString());
        $productCart3 = new ProductCart(Uuid::uuid4()->toString());

        $products[1]->addProductCart($productCart1);
        $cart->addProductCart($productCart1);
        $products[1]->addProductCart($productCart2);
        $cart->addProductCart($productCart2);
        $products[1]->addProductCart($productCart3);
        $cart->addProductCart($productCart3);

        $manager->persist($cart);
        $manager->persist($cart2);
        $manager->flush();
    }
}
