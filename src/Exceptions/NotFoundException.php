<?php

namespace Rainwaves\Exceptions;

class NotFoundException extends ColliveryException
{
    /**
     * NotFoundException constructor.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = "Not Found: The requested resource could not be found", $code = 404)
    {
        parent::__construct($message, $code);
    }
}