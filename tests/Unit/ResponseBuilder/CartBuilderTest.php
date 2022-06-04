<?php

declare(strict_types=1);

namespace App\Tests\Unit\ResponseBuilder;

use App\Entity\Cart;
use App\Entity\Product;
use App\Entity\ProductCart;
use App\ResponseBuilder\CartBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \App\ResponseBuilder\CartBuilder
 */
class CartBuilderTest extends TestCase
{
    private CartBuilder $builder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->builder = new CartBuilder();
    }

    public function testBuildsCartWithNoProducts(): void
    {
        $cart = new Cart('3db5f857-e5a3-4c8d-a262-37da156c0001');

        $this->assertEquals([
            'total_price' => 0,
            'products'    => [],
        ], $this->builder->__invoke($cart));
    }

    public function testBuildsCartWithProducts(): void
    {
        $productCart = new ProductCart('3db5f857-e5a3-4c8d-a262-37da156c0001');
        $productCart2 = new ProductCart('3db5f857-e5a3-4c8d-a262-37da156c0001');
        $cart = new Cart('16e0226c-0ed8-434a-9342-429aefeb98f0');


        $product = (new Product('16e0226c-0ed8-434a-9342-429aefeb98f0', 'Product 1', 1990, 4));
        $product2 = (new Product('16e0226c-0ed8-434a-9342-429aefeb98f0', 'Product 2', 3690, 4));

        $cart->addProductCart($productCart);
        $cart->addProductCart($productCart2);
        $product->addProductCart($productCart);
        $product2->addProductCart($productCart2);


        $this->assertEquals([
            'total_price' => 5680,
            'products'    => [
                [
                    'id'    => '16e0226c-0ed8-434a-9342-429aefeb98f0',
                    'name'  => 'Product 1',
                    'price' => 1990,
                    'quantity' => 4,
                    'created_at'=> (new \DateTime())->format('Y-m-d H:i:s')
                ],

                [
                    'id'    => '16e0226c-0ed8-434a-9342-429aefeb98f0',
                    'name'  => 'Product 2',
                    'price' => 3690,
                    'quantity' => 4,
                    'created_at'=> (new \DateTime())->format('Y-m-d H:i:s')
                ],
            ],
        ], $this->builder->__invoke($cart));
    }
}
