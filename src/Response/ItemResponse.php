<?php
/**
 * Erply Books API PHP client
 *
 * @author Rene Korss <rene@koren.ee>
 * @copyright Copyright (c) 2023 Rene Korss (https://koren.ee)
 * @license MIT
 */

namespace Koren\ErplyBooks\Response;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

/**
 * One item response
 */
class ItemResponse extends Response
{
    /**
     * Item
     * @var object
     */
    protected $item = null;

    /**
     * constructor
     *
     * @param \GuzzleHttp\Psr7\Response $response Response object
     */
    public function __construct(GuzzleResponse $response)
    {
        parent::__construct($response);

        if ($response->getStatusCode() == 200) {
            if (isset($this->body) && is_object($this->body)) {
                $this->item = $this->body;
            }
        }
    }

    /**
     * Get item
     *
     * @return object Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Countable
     *
     * @return int Count of items
     */
    public function count() : int
    {
        return $this->getItem() ? 1 : 0;
    }

    /**
     * JsonSerializable
     *
     * @return object Item
     */
    public function jsonSerialize() : mixed
    {
        return $this->getItem();
    }

    /**
     * Magic method so we can echo item
     */
    public function __toString()
    {
        return json_encode($this->getItem());
    }

    /**
     * Property overloading
     * This way we can get item data directly from response
     *
     * @param string $name Property name
     *
     * @return mixed Property value or false if dosen't exist
     */
    public function __get($name)
    {
        if (isset($this->item->{$name})) {
            return $this->item->{$name};
        }

        return false;
    }

    /**
     * Detect if item has specified property
     *
     * @param string $name Property name
     *
     * @return boolean True if property exists, false otherwise
     */
    public function __isset($name)
    {
        return isset($this->item->{$name});
    }
}
