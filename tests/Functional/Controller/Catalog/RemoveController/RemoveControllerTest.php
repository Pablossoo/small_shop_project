<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller\Catalog\RemoveController;

use App\Tests\Functional\WebTestCase;

class RemoveControllerTest extends WebTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures(new RemoveControllerFixture());
    }

    public function testRemovesProduct(): void
    {
        $this->client->request('DELETE', '/products/' . RemoveControllerFixture::PRODUCT_ID);

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');
        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertCount(0, $response['products']);
    }

    public function testSilentlyIgnoresProductThatDoesNotExist(): void
    {
        $this->client->request('DELETE', '/products/b0263fef-82c6-49bc-81f8-a4ce7066f1d7');

        self::assertResponseStatusCodeSame(202);

        $this->client->request('GET', '/products');
        self::assertResponseStatusCodeSame(200);

        $response = $this->getJsonResponse();
        self::assertCount(1, $response['products']);
    }
}
