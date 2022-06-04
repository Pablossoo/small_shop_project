<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Cart\RemoveProductController;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\ProductCart;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class RemoveProductControllerFixture extends AbstractFixture
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product('d11e1e69-cca7-40a1-8273-9d93c8346efd', 'Product 1', 1990,5);
        $manager->persist($product);

        $product2 = new Product('7bcf6fe9-e831-4776-a9df-76a702233adc', 'Product 2', 2990,5);
        $manager->persist($product2);

        $cart = new ProductCart('97e385fe-9876-45fc-baa0-4f2f0df90950');
        $cart->setProduct($product);
        $manager->persist($cart);

        $manager->flush();
    }
}
