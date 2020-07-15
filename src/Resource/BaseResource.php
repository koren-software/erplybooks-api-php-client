<?php
/**
 * Erply Books API PHP client
 *
 * @author Rene Korss <rene@koren.ee>
 * @copyright Copyright (c) 2020 Rene Korss (https://koren.ee)
 * @license MIT
 */

namespace Koren\ErplyBooks\Resource;

use GuzzleHttp\Psr7\Request;
use Koren\ErplyBooks\Client;
use Koren\ErplyBooks\Response\ItemResponse;
use Koren\ErplyBooks\Response\ItemsResponse;
use Koren\ErplyBooks\Response\Response;
use RuntimeException;

/**
 * Resource base class
 */
abstract class BaseResource
{
    /**
     * Resolve Client
     * @var \Koren\ErplyBooks\Client
     */
    protected $client;

    /**
     * Endpoint
     * @var string
     */
    protected $endpoint = null;

    /**
     * Constructor
     *
     * @throws \RuntimeException if endpoint is not set
     */
    public function __construct()
    {
        if (strlen($this->endpoint) === 0) {
            throw new RuntimeException(__CLASS__.' dosen\'t have endpoint.'); // @codeCoverageIgnore
        }
    }

    /**
     * Set the API client
     *
     * @param \Koren\ErplyBooks\Client $client
     *
     * @return \Koren\ErplyBooks\Client
     */
    public function setClient(Client $client) : self
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Get the API client
     *
     * @return \Koren\ErplyBooks\Client
     */
    public function getClient() : Client
    {
        return $this->client;
    }

    /**
     * Get endpoint
     *
     * @return string Endpoint
     */
    public function getEndpoint() : string
    {
        return $this->endpoint;
    }

    /**
     * Get endpoint url
     *
     * @return string Endpoint URL
     */
    public function getEndpointUrl() : string
    {
        return \Koren\ErplyBooks\Client::BASE_URL.'/'.$this->getEndpoint();
    }

    /**
     * GET query
     *
     * @param mixed $parameters
     *
     * @return \Koren\ErplyBooks\Response\Response
     */
    public function get($parameters = null) : Response
    {
        $client = $this->getClient();
        $url = $this->getEndpointUrl();

        // Get certain item by ID
        if (is_int($parameters)) {
            $url .= '/'.$parameters;
        // Get items by parameters
        } elseif (is_array($parameters)) {
            $client = $client->withQuery($parameters);
        }

        $response = $client->sendRequest(
            new Request('GET', $url)
        );

        $body = json_decode($response->getBody());
        if (isset($body->items)) {
            return new ItemsResponse($response);
        }

        return new ItemResponse($response);
    }

    /**
     * POST query
     *
     * @param array $data
     *
     * @return \Koren\ErplyBooks\Response\ItemResponse
     */
    public function post($data = []) : ItemResponse
    {
        return new ItemResponse(
            $this->getClient()->sendRequest(
                new Request(
                    'POST',
                    $this->getEndpointUrl(),
                    ['Content-Type' => 'application/json'],
                    \GuzzleHttp\Psr7\stream_for(http_build_query($data))
                )
            )
        );
    }

    /**
     * PUT query
     *
     * @param int $itemId
     * @param array $data
     *
     * @return \Koren\ErplyBooks\Response\ItemResponse
     */
    public function put(int $itemId, $data = []) : ItemResponse
    {
        return new ItemResponse(
            $this->getClient()->sendRequest(
                new Request(
                    'PUT',
                    $this->getEndpointUrl().'/'.$itemId,
                    ['Content-Type' => 'application/json'],
                    \GuzzleHttp\Psr7\stream_for(http_build_query($data))
                )
            )
        );
    }

    /**
     * DELETE query
     *
     * @param int $itemId
     *
     * @return \Koren\ErplyBooks\Response\ItemResponse
     */
    public function delete(int $itemId) : ItemResponse
    {
        return new ItemResponse(
            $this->getClient()->sendRequest(
                new Request('DELETE', $this->getEndpointUrl().'/'.$itemId)
            )
        );
    }
}
