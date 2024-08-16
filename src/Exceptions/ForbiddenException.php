<?php

namespace Rainwaves\Exceptions;

class ForbiddenException extends ColliveryException
{
    /**
     * ForbiddenException constructor.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = "Forbidden: You do not have permission to access this resource", $code = 403)
    {
        parent::__construct($message, $code);
    }
}