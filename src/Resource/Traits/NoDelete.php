<?php
/**
 * Erply Books API PHP client
 *
 * @author Rene Korss <rene@koren.ee>
 * @copyright Copyright (c) 2023 Rene Korss (https://koren.ee)
 * @license MIT
 */

namespace Koren\ErplyBooks\Resource\Traits;

use BadMethodCallException;
use Koren\ErplyBooks\Response\ItemResponse;
use ReflectionClass;

/**
 * Trait that denies DELETE requests
 */
trait NoDelete
{
    /**
     * DELETE query
     *
     * @param int $itemId
     * @param array $data
     *
     * @return \Koren\ErplyBooks\Response\ItemResponse
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function delete(int $itemId, $data = []) : ItemResponse
    {
        throw new BadMethodCallException(
            'DELETE request is not supported on '.(new ReflectionClass($this))->getShortName().' resource.'
        );
    }
}
