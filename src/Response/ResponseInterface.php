<?php
/**
 * Erply Books API PHP client
 *
 * @author Rene Korss <rene@koren.ee>
 * @copyright Copyright (c) 2023 Rene Korss (https://koren.ee)
 * @license MIT
 */

namespace Koren\ErplyBooks\Response;

use GuzzleHttp\Psr7\Response;

/**
 * Iterface for responses, all response classes must implement this
 */
interface ResponseInterface extends \Countable, \JsonSerializable
{
    /**
     * Cosntructor
     *
     * @param \GuzzleHttp\Psr7\Response $response Response object
     */
    public function __construct(Response $response);

    /**
     * Countable
     *
     * @return int Count of items
     */
    public function count() : int;

    /**
     * JsonSerializable
     *
     * @return object Item
     */
    public function jsonSerialize() : mixed;

    /**
     * Magic method so we can still call original response methods
     *
     * @ignore
     */
    public function __call($name, $arguments);
}
