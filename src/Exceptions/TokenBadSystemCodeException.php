<?php

namespace Zdrojowa\AuthenticationLink\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Class TokenBadSystemCodeException
 * @package Zdrojowa\AuthenticationLink\Exceptions
 */
class TokenBadSystemCodeException extends Exception
{
    /**
     * TokenBadSystemCodeException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Your environment system code is not matching provided token: ' . $message, $code, $previous);
    }

    public function report()
    {
        Log::debug($this->message);
    }
}
