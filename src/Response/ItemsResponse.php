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
 * Items response, iterable
 */
class ItemsResponse extends Response implements \Iterator
{
    /**
     * Items
     * @var array
     */
    protected $items = [];

    /**
     * Iterator position
     * @var int
     */
    private $position = 0;

    /**
     * constructor
     *
     * @param \GuzzleHttp\Psr7\Response $response Response object
     */
    public function __construct(GuzzleResponse $response)
    {
        parent::__construct($response);

        $this->position = 0;

        if ($response->getStatusCode() == 200) {
            if (isset($this->body->items) && is_array($this->body->items)) {
                $this->items = $this->body->items;
            }
        }
    }

    /**
     * Get items
     *
     * @return array Items
     */
    public function getItems() : array
    {
        return $this->items;
    }

    /**
     * Iterator
     *
     * @ignore
     */
    public function current() : mixed
    {
        return $this->items[$this->position];
    }

    public function key() : mixed
    {
        return $this->position;
    }

    public function next() : void
    {
        ++$this->position;
    }

    public function rewind() : void
    {
        $this->position = 0;
    }

    public function valid() : bool
    {
        return isset($this->items[$this->position]);
    }

    /**
     * Countable
     *
     * @return int Count of items
     */
    public function count() : int
    {
        return count($this->items);
    }

    /**
     * JsonSerializable
     *
     * @return array Items
     */
    public function jsonSerialize() : mixed
    {
        return $this->getItems();
    }

    /**
     * Magic method so we can echo items
     */
    public function __toString()
    {
        return json_encode($this->items);
    }
}
