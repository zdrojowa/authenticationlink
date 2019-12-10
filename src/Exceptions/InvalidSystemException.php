<?php

namespace Zdrojowa\AuthenticationLink\Exceptions;

use Exception;
use Throwable;

class InvalidSystemException extends Exception
{
    public function __construct($message = "Incorrect system code", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
