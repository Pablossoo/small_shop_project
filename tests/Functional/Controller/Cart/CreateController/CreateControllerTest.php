<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Cart\CreateController;

use App\Tests\Functional\WebTestCase;

class CreateControllerTest extends WebTestCase
{
    public function testCreatesCart(): void
    {
        $this->client->request('POST', '/cart');

        self::assertResponseStatusCodeSame(201);

        $response = $this->getJsonResponse();
        $id       = $response['cart_id'];

        $this->client->request('GET', '/cart/' . $id);
        self::assertResponseStatusCodeSame(200);
    }
}
