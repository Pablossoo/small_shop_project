<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Cart\AddProductController;

use App\Tests\Functional\WebTestCase;

class AddProductControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures(new AddProductControllerFixture());
    }

    public function testAddsProductToCart(): void
    {
        $this->client->request('PUT', '/cart/5bd88887-7017-4c08-83de-8b5d9abde58c/fbcb8c51-5dcc-4fd4-a4cd-ceb9b400bff7');
        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/cart/5bd88887-7017-4c08-83de-8b5d9abde58c');
        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertCount(1, $response['products']);
    }

    public function testRefusesToAddFourthProductToCart(): void
    {
        $this->client->request('PUT', '/cart/1e82de36-23f3-4ae7-ad5d-616295f1d6c0/00e91390-3af8-4735-bd06-0311e7131757');
        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponse();
        self::assertEquals([
            'error_message' => 'Cart is full.',
        ], $response);

        $this->client->request('GET', '/cart/1e82de36-23f3-4ae7-ad5d-616295f1d6c0');
        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertCount(3, $response['products']);
    }

    public function testReturns404IfCartDoesNotExist(): void
    {
        $this->client->request('PUT', '/cart/8e9efe09-3f5b-4681-9f6a-adb4a5a9f19c/00e91390-3af8-4735-bd06-0311e7131757');
        self::assertResponseStatusCodeSame(404);
    }

    public function testReturns404IfProductDoesNotExist(): void
    {
        $this->client->request('PUT', '/cart/5bd88887-7017-4c08-83de-8b5d9abde58c/b832e983-6159-47db-a98f-575a46d9544c');
        self::assertResponseStatusCodeSame(404);
    }
}
