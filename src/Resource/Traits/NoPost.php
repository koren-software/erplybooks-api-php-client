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
 * Trait that denies POST requests
 */
trait NoPost
{
    /**
     * POST query
     *
     * @param array $data
     *
     * @return \Koren\ErplyBooks\Response\ItemResponse
     *
     * @throws BadMethodCallException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function post($data = []) : ItemResponse
    {
        throw new BadMethodCallException(
            'POST request is not supported on '.(new \ReflectionClass($this))->getShortName().' resource.'
        );
    }
}
