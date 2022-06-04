<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Catalog\ListController;

use App\Tests\Functional\WebTestCase;

class ListControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures(new ListControllerFixture());
    }

    public function testShowsFirstPageOfProducts(): void
    {
        $this->client->request('GET', '/products');

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertEquals([
            'previous_page' => null,
            'next_page'     => '/products?page=1',
            'count'         => 7,
            'products'      => [
                [
                    'id'    => 'fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7',
                    'name'  => 'Product 1',
                    'price' => 1990,
                    'quantity' => 4,
                    'createdAt' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                [
                    'id'    => '9670ea5b-d940-4593-a2ac-4589be784203',
                    'name'  => 'Product 2',
                    'price' => 3990,
                    'quantity' => 3,
                    'createdAt' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                [
                    'id'    => '15e4a636-ef98-445b-86df-46e1cc0e10b5',
                    'name'  => 'Product 3',
                    'price' => 4990,
                    'quantity' => 2,
                    'createdAt' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
            ],
        ], $response);
    }

    public function testShowsMiddlePageOfProducts(): void
    {
        $this->client->request('GET', '/products?page=1');

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertEquals([
            'previous_page' => '/products?page=0',
            'next_page'     => '/products?page=2',
            'count'         => 7,
            'products'      => [
                [
                    'id'    => '00e91390-3af8-4735-bd06-0311e7131757',
                    'name'  => 'Product 4',
                    'price' => 5990,
                    'quantity' => 7,
                    'createdAt' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                [
                    'id'    => '0a5d83f1-8c7e-4253-b020-156439f3d3c9',
                    'name'  => 'Product 5',
                    'price' => 6990,
                    'quantity' => 55,
                    'createdAt' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                [
                    'id'    => 'e41ac303-11ab-446e-a253-28572278fdbe',
                    'name'  => 'Product 6',
                    'price' => 7990,
                    'quantity' => 76,
                    'createdAt' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
            ],
        ], $response);
    }

    public function testShowsLastPageOfProducts(): void
    {
        $this->client->request('GET', '/products?page=2');

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertEquals([
            'previous_page' => '/products?page=1',
            'next_page'     => null,
            'count'         => 7,
            'products'      => [
                [
                    'id'    => 'b7747f7b-ae35-4225-af9a-6ecc803ebf0f',
                    'name'  => 'Product 7',
                    'price' => 8990,
                    'quantity' => 54,
                    'createdAt' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
            ],
        ], $response);
    }

    public function testShowsFirstPageOfProductsIfPageIsSetToNegativeNumber(): void
    {
        $this->client->request('GET', '/products?page=-1');

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertEquals([
            'previous_page' => null,
            'next_page'     => '/products?page=1',
            'count'         => 7,
            'products'      => [
                [
                    'id'    => 'fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7',
                    'name'  => 'Product 1',
                    'price' => 1990,
                    'quantity' => 4,
                    'createdAt' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                [
                    'id'    => '9670ea5b-d940-4593-a2ac-4589be784203',
                    'name'  => 'Product 2',
                    'price' => 3990,
                    'quantity' => 3,
                    'createdAt' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
                [
                    'id'    => '15e4a636-ef98-445b-86df-46e1cc0e10b5',
                    'name'  => 'Product 3',
                    'price' => 4990,
                    'quantity' => 2,
                    'createdAt' => (new \DateTime())->format('Y-m-d H:i:s')
                ],
            ],
        ], $response);
    }

    public function testShowsEmptyResultSetIfPageIsBeyondNumberOfAvailablePages(): void
    {
        $this->client->request('GET', '/products?page=3');

        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertEquals([
            'previous_page' => '/products?page=2',
            'next_page'     => null,
            'count'         => 7,
            'products'      => [],
        ], $response);
    }
}
