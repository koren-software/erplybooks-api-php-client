<?php
/**
 * Erply Books API PHP client
 *
 * @author Rene Korss <rene@koren.ee>
 * @copyright Copyright (c) 2023 Rene Korss (https://koren.ee)
 * @license MIT
 */

namespace Koren\ErplyBooks\Tests;

use Exception;
use GuzzleHttp\Handler\MockHandler;
use Http\Adapter\Guzzle7\Client as GuzzleClient;
use Koren\ErplyBooks\Client;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    protected $token;

    /** @var \Koren\ErplyBooks\Client $client */
    protected $client;
    protected $mockHandler;

    protected function setUp() : void
    {
        $this->token = 'test-key';

        try {
            $this->mockHandler = new MockHandler();

            $httpClient = GuzzleClient::createWithConfig([
                'handler' => $this->mockHandler,
            ]);

            // Create client
            $this->client = new Client($this->token, $httpClient);
        } catch (Exception $e) {
            echo 'ERROR: '.$e->getMessage();
        }
    }

    /**
     * Get fixture file contents
     *
     * @param string $fileName
     *
     * @return string
     */
    protected function getFixture(string $fileName) : string
    {
        return file_get_contents(__DIR__.'/fixtures/'.$fileName);
    }
}
