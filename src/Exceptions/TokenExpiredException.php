<?php

namespace Zdrojowa\AuthenticationLink\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Class TokenExpiredException
 * @package Zdrojowa\AuthenticationLink\Exceptions
 */
class TokenExpiredException extends Exception
{
    /**
     * TokenExpiredException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Provided token is expired: ' . $message, $code, $previous);
    }

    public function report()
    {
        Log::debug($this->message);
    }
}
