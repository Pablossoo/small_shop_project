<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Catalog\AddController;

use App\Tests\Functional\WebTestCase;

class AddControllerTest extends WebTestCase
{
    public function testAddsProduct(): void
    {
        $this->client->jsonRequest('POST', '/products', [
            'name'  => 'Product name',
            'price' => 1990,
        ]);

        self::assertResponseStatusCodeSame(202);

        $this->client->jsonRequest('GET', '/products');
        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertCount(1, $response['products']);
        self::assertequals('Product name', $response['products'][0]['name']);
        self::assertequals(1990, $response['products'][0]['price']);
    }

    public function testProductWithEmptyNameCannotBeAdded(): void
    {
        $this->client->jsonRequest('POST', '/products', [
            'name'  => '    ',
            'price' => 1990,
        ]);

        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponse();

        self::assertequals('Invalid name or price.', $response['error_message']);
    }

    public function testProductWithoutAPriceCannotBeAdded(): void
    {
        $this->client->jsonRequest('POST', '/products', [
            'name' => 'Product name',
        ]);

        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponse();
        self::assertequals('Invalid name or price.', $response['error_message']);
    }

    public function testProductWithNonPositivePriceCannotBeAdded(): void
    {
        $this->client->jsonRequest('POST', '/products', [
            'name'  => 'Product name',
            'price' => 0,
        ]);

        self::assertResponseStatusCodeSame(422);

        $response = $this->getJsonResponse();
        self::assertequals('Invalid name or price.', $response['error_message']);
    }
}
