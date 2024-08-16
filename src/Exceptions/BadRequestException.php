<?php

namespace Rainwaves\Exceptions;

class BadRequestException extends ColliveryException
{
    /**
     * BadRequestException constructor.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = "Bad Request: The request could not be understood or was missing required parameters", $code = 400)
    {
        parent::__construct($message, $code);
    }
}