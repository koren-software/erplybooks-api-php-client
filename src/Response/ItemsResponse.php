<?php
/**
 * Erply Books API PHP client
 *
 * @author Rene Korss <rene@koren.ee>
 * @copyright Copyright (c) 2020 Rene Korss (https://koren.ee)
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
    public function current()
    {
        return $this->items[$this->position];
    }

    /**
     * @ignore
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * @ignore
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * @ignore
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @ignore
     */
    public function valid()
    {
        return isset($this->items[$this->position]);
    }

    /**
     * Countable
     *
     * @return int Count of items
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * JsonSerializable
     *
     * @return array Items
     */
    public function jsonSerialize()
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
