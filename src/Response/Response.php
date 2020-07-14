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

abstract class Response implements ResponseInterface
{
    /**
     * Response
     * @var \GuzzleHttp\Psr7\Response
     */
    protected $response = null;

    /**
     * Body
     * @var object
     */
    protected $body = null;

    /**
     * Error(s)
     * @var mixed
     */
    protected $error = null;

    /**
     * Constructor
     *
     * @param \GuzzleHttp\Psr7\Response $response Response object
     */
    public function __construct(GuzzleResponse $response)
    {
        $this->response = $response;
        $this->body = json_decode($this->response->getBody());

        if (isset($this->body->exception)) {
            $this->error = $this->body;
        }
    }

    /**
     * Get error
     *
     * @return mixed Null, if no error, object otherwise
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Magic method so we can still call original response methods
     *
     * @ignore
     * @codeCoverageIgnore
     */
    public function __call($name, $arguments)
    {
        if (method_exists($this->response, $name)) {
            return call_user_func_array([$this->response, $name], $arguments);
        }

        return false;
    }
}
