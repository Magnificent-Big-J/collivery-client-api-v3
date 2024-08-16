<?php

namespace Rainwaves\Exceptions;

class ValidationException extends ColliveryException
{
    /**
     * ValidationException constructor.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message = "Validation Error: The input data is invalid", $code = 422)
    {
        parent::__construct($message, $code);
    }
}
