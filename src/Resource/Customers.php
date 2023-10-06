<?php
/**
 * Erply Books API PHP client
 *
 * @author Rene Korss <rene@koren.ee>
 * @copyright Copyright (c) 2023 Rene Korss (https://koren.ee)
 * @license MIT
 */

namespace Koren\ErplyBooks\Resource;

/**
 * Resource base class
 */
class Customers extends BaseResource
{
    use Traits\NoPost;
    use Traits\NoPut;
    use Traits\NoDelete;

    /**
     * Endpoint
     * @var string
     */
    protected $endpoint = 'customers';
}
