<?php
/**
 * Erply Books API PHP client
 *
 * @author Rene Korss <rene@koren.ee>
 * @copyright Copyright (c) 2020 Rene Korss (https://koren.ee)
 * @license MIT
 */

namespace Koren\ErplyBooks\Tests;

use BadMethodCallException;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Koren\ErplyBooks\Response\ItemResponse;
use Koren\ErplyBooks\Response\ItemsResponse;

final class ResourceTest extends BaseTest
{
    protected function setUp() : void
    {
        parent::setUp();
    }

    public function testGetMany()
    {
        /** @var \Koren\ErplyBooks\Resource\Invoices $invoices */
        $invoices = $this->client->Invoices();

        $this->mockHandler->append(new GuzzleResponse(200, [], $this->getFixture('invoices-get-many.json')));

        /** @var \Koren\ErplyBooks\Response\ItemsResponse $response */
        $response = $invoices->get([
            'limit' => 500
        ]);

        $this->assertInstanceOf(ItemsResponse::class, $response);

        // Is countable
        $this->assertCount(1, $response);

        // Is JSON serializable
        $this->isJson(json_encode($response));
        $this->isJson($response->__toString());

        // Is iterable
        $this->count(1, iterator_to_array($response));

        $this->mockHandler->append(new GuzzleResponse(200, [], $this->getFixture('invoices-get-many-null.json')));

        /** @var \Koren\ErplyBooks\Response\ItemsResponse $response */
        $response = $invoices->get([
            'limit' => 500
        ]);

        $this->assertInstanceOf(ItemsResponse::class, $response);
    }

    public function testGetOne()
    {
        /** @var \Koren\ErplyBooks\Resource\Invoices $invoices */
        $invoices = $this->client->Invoices();

        $this->mockHandler->append(new GuzzleResponse(200, [], $this->getFixture('invoices-get-one.json')));

        $response = $invoices->get(1);

        $this->assertInstanceOf(ItemResponse::class, $response);

        // Is countable
        $this->assertCount(1, $response);

        // Is JSON serializable
        $this->isJson(json_encode($response));
        $this->isJson($response->__toString());

        // Can get data
        $this->assertSame(1, $response->id);
        $this->assertFalse($response->notExistingProperty);
        $this->assertTrue(isset($response->id));
    }

    public function testPost()
    {
        /** @var \Koren\ErplyBooks\Resource\Invoices $invoices */
        $invoices = $this->client->Invoices();

        $this->mockHandler->append(new GuzzleResponse(200, [], $this->getFixture('invoices-get-one.json')));

        $response = $invoices->post();

        $this->assertInstanceOf(ItemResponse::class, $response);
    }

    public function testPut()
    {
        /** @var \Koren\ErplyBooks\Resource\Invoices $invoices */
        $invoices = $this->client->Invoices();

        $this->mockHandler->append(new GuzzleResponse(200, [], $this->getFixture('invoices-get-one.json')));

        $response = $invoices->put(1, []);

        $this->assertInstanceOf(ItemResponse::class, $response);
    }

    public function testDelete()
    {
        /** @var \Koren\ErplyBooks\Resource\Invoices $invoices */
        $invoices = $this->client->Invoices();

        $this->mockHandler->append(new GuzzleResponse(200, [], $this->getFixture('invoices-get-one.json')));

        $response = $invoices->delete(1);

        $this->assertInstanceOf(ItemResponse::class, $response);
    }

    public function testCallUnsupportedPostRequest()
    {
        /** @var \Koren\ErplyBooks\Resource\Customers $customers */
        $customers = $this->client->Customers();

        $this->expectException(BadMethodCallException::class);
        $customers->post([]);
    }

    public function testCallUnsupportedPutRequest()
    {
        /** @var \Koren\ErplyBooks\Resource\Customers $customers */
        $customers = $this->client->Customers();

        $this->expectException(BadMethodCallException::class);
        $customers->put(1, []);
    }

    public function testCallUnsupportedDeleteRequest()
    {
        /** @var \Koren\ErplyBooks\Resource\Customers $customers */
        $customers = $this->client->Customers();

        $this->expectException(BadMethodCallException::class);
        $customers->delete(1);
    }

    public function testHandlingErrors()
    {
        /** @var \Koren\ErplyBooks\Resource\Invoices $invoices */
        $invoices = $this->client->Invoices();

        $this->mockHandler->append(new GuzzleResponse(200, [], $this->getFixture('error.json')));

        $response = $invoices->delete(100);

        $this->assertInstanceOf(ItemResponse::class, $response);

        $error =$response->getError();
        $this->assertSame('DataConflictException', $error->exceptionType);
        $this->assertObjectHasAttribute('messages', $error->exception);
        $this->assertSame('Item not Found', $error->exception->messages[0]->messageCode);
    }
}
