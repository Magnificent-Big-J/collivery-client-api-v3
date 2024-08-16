<?php

namespace Rainwaves\Exceptions;

class ServerException extends ColliveryException
{
    /**
     * ServerException constructor.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = "Server Error: An error occurred on the server", $code = 500)
    {
        parent::__construct($message, $code);
    }
}