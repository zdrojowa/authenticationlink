<?php

namespace Zdrojowa\AuthenticationLink\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * Class TokenNotFoundException
 * @package Zdrojowa\AuthenticationLink\Exceptions
 */
class TokenNotFoundException extends Exception
{
    /**
     * TokenNotFoundException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Token not found: ' . $message, $code, $previous);
    }

    public function report()
    {
        Log::debug($this->message);
    }
}
