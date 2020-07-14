<?php
/**
 * Erply Books API PHP client
 *
 * @author Rene Korss <rene@koren.ee>
 * @copyright Copyright (c) 2020 Rene Korss (https://koren.ee)
 * @license MIT
 */

namespace Koren\ErplyBooks\Tests;

use Koren\ErplyBooks\Response\ItemResponse;
use Koren\ErplyBooks\Response\ItemsResponse;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

final class InvoicesTest extends BaseTest
{
    protected function setUp() : void
    {
        parent::setUp();
    }

    public function testGetMany()
    {
        /** @var \Koren\ErplyBooks\Resource\Invoices $invoicesResource */
        $invoicesResource = $this->client->Invoices();

        $this->mockHandler->append(new GuzzleResponse(200, [], $this->getFixture('invoices-get-many.json')));

        $response = $invoicesResource->get();

        $this->assertInstanceOf(ItemsResponse::class, $response);
    }

    public function testGetOne()
    {
        /** @var \Koren\ErplyBooks\Resource\Invoices $invoicesResource */
        $invoicesResource = $this->client->Invoices();

        $this->mockHandler->append(new GuzzleResponse(200, [], $this->getFixture('invoices-get-one.json')));

        $response = $invoicesResource->get();

        $this->assertInstanceOf(ItemResponse::class, $response);
    }
}
