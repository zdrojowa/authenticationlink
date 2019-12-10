<?php

namespace Zdrojowa\AuthenticationLink\Support;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Zdrojowa\AuthenticationLink\Models\AuthenticationLink;
use Illuminate\Support\Str;
use Zdrojowa\AuthenticationLink\Models\System;

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

    /**
     * @param string $token
     *
     * @return string|null
     */
    public function tokenLink(string $token): ?string
    {
        $token = AuthenticationLink::where('token', $token)->with('system')->with('user')->first();

        if (!$token) return null;

        return str_replace(':token', $token->token, $token->system->login_url);
    }

}
