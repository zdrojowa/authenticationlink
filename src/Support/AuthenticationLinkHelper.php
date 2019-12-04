<?php

namespace Zdrojowa\Authenticationlink\Support;

use Zdrojowa\Authenticationlink\Models\AuthenticationLink;
use Illuminate\Support\Str;

/**
 * Class AuthenticationLinkHelper
 * @package Zdrojowa\AuthenticationLink\Support
 */
class AuthenticationLinkHelper
{
    /**
     * @return string
     */
    public function generateToken(): string
    {
        $randomString = Str::random(100);

        if (AuthenticationLink::where('token', $randomString)->exists()) $this->generateToken();

        return $randomString;
    }
}
