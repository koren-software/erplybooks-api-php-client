<?php
/**
 * Erply Books API PHP client
 *
 * @author Rene Korss <rene@koren.ee>
 * @copyright Copyright (c) 2020 Rene Korss (https://koren.ee)
 * @license MIT
 */

namespace Koren\ErplyBooks\Resource\Traits;

use BadMethodCallException;
use Koren\ErplyBooks\Response\ItemResponse;

/**
 * Trait that denies PUT requests
 */
trait NoPut
{
    /**
     * PUT query
     *
     * @param int $itemId
     * @param array $data
     *
     * @return \Koren\ErplyBooks\Response\ItemResponse
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function put(int $itemId, $data = []) : ItemResponse
    {
        throw new BadMethodCallException(
            'PUT request is not supported on '.(new \ReflectionClass($this))->getShortName().' resource.'
        );
    }
}
