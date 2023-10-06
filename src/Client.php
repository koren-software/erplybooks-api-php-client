<?php
/**
 * Erply Books API PHP client
 *
 * @author Rene Korss <rene@koren.ee>
 * @copyright Copyright (c) 2023 Rene Korss (https://koren.ee)
 */

namespace Koren\ErplyBooks;

use Http\Adapter\Guzzle7\Client as GuzzleClient;
use Http\Client\HttpClient;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Erply Books API PHP client Client class
 *
 * @author Rene Korss <rene@koren.ee>
 * @copyright Copyright (c) 2023 Rene Korss (https://koren.ee)
 * @license MIT
 */
class Client
{
    /**
     * API base URL
     * @var string
     */
    const BASE_URL = 'https://accounting.erply.com/api';

    /**
     * API token
     * @var String
     */
    protected $token;

    /**
     * Http Client
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * Additional query params
     * @var array
     */
    protected $query = [];

    /**
     * API client constructor
     *
     * @param string $token API token
     * @param \Http\Client\HttpClient $client HTTP Client used for requests
     */
    public function __construct($token, HttpClient $client = null)
    {
        // Fallback to Guzzle
        if (is_null($client)) {
            $client = new GuzzleClient();
        }

        $this->token = $token;

        $this->setHttpClient($client);
    }


    /**
     * Get API token
     */
    public function getApiToken() : string
    {
        return $this->token;
    }

    /**
     * Set the Http Client used for API requests
     *
     * This allows the default http client to be swapped out for a HTTPlug compatible
     * replacement.
     *
     * @param \Http\Client\HttpClient $client
     *
     * @return \Resolve\Api\Client
     */
    public function setHttpClient(HttpClient $client) : self
    {
        $this->httpClient = $client;
        return $this;
    }

    /**
     * Get the Http Client used for API requests
     *
     * @return \Http\Client\HttpClient
     */
    public function getHttpClient() : HttpClient
    {
        return $this->httpClient;
    }

    /**
     * Adds token to request
     *
     * @param \Psr\Http\Message\RequestInterface $request Request being sent
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    public function authenticate(RequestInterface $request) : RequestInterface
    {
        $request = $request->withHeader('Content-Type', 'application/json');
        $request = $request->withHeader('Accept', 'application/json');

        $this->withQuery([
            'token' => $this->token
        ]);

        return $request;
    }

    /**
     * Add query param
     *
     * @param array $param Key and value array of param
     *
     * @return \Resolve\Api\Client
     */
    public function withQuery(array $param) : self
    {
        $this->query = array_merge($this->query, $param);
        return $this;
    }

    /**
     * Add query param
     *
     * @param \Psr\Http\Message\RequestInterface $request Request being sent
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    protected function withQueryParams(RequestInterface $request) : RequestInterface
    {
        if (count($this->query) > 0) {
            $query = [];
            parse_str($request->getUri()->getQuery(), $query);
            $query = array_merge($query, $this->query);
            $request = $request->withUri($request->getUri()->withQuery(http_build_query($query)));
        }

        return $request;
    }

    /**
     * Send request
     *
     * @param \Psr\Http\Message\RequestInterface $request Request being sent
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendRequest(RequestInterface $request) : ResponseInterface
    {
        // Add apiKey to request
        $request = $this->authenticate($request);

        // Add query params if any
        $request = $this->withQueryParams($request);

        $response = $this->getHttpClient()->sendRequest($request);
        return $response;
    }

    /**
     * Magic method to get resource object
     *
     * @return mixed Resource
     *
     * @throws \InvalidArgumentException if resource is not found
     * @ignore
     * @SuppressWarnings(PHPMD.MissingImport)
     */
    public function __call($name, $args)
    {
        $className = 'Koren\ErplyBooks\Resource\\'.$name;

        if (!class_exists($className)) {
            throw new InvalidArgumentException('Resource '.$name.' not found.');
        }

        $resource = new $className;
        $resource->setClient($this);

        return $resource;
    }
}
