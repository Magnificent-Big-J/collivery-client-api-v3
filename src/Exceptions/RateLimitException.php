<?php

namespace Rainwaves\Exceptions;

class RateLimitException extends ColliveryException
{
    /**
     * RateLimitException constructor.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = "Rate Limit Exceeded: Too many requests", $code = 429)
    {
        parent::__construct($message, $code);
    }
}