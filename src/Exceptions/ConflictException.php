<?php

namespace Rainwaves\Exceptions;

class ConflictException extends ColliveryException
{
    /**
     * ConflictException constructor.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = "Conflict: The request could not be completed due to a conflict with the current state of the resource", $code = 409)
    {
        parent::__construct($message, $code);
    }
}