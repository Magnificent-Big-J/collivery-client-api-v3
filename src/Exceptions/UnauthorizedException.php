<?php

namespace Rainwaves\Exceptions;

class UnauthorizedException extends ColliveryException
{
    /**
     * UnauthorizedException constructor.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = "Unauthorized: Invalid API credentials", $code = 401)
    {
        parent::__construct($message, $code);
    }
}