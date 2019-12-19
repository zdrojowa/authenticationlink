<?php

namespace Zdrojowa\AuthenticationLink\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Zdrojowa\AuthenticationLink\Contracts\AuthenticationLinkContract;
use Zdrojowa\AuthenticationLink\Exceptions\TokenBadSystemCodeException;
use Zdrojowa\AuthenticationLink\Exceptions\TokenExpiredException;
use Zdrojowa\AuthenticationLink\Exceptions\TokenNotFoundException;

/**
 * Class AuthenticationLinkController
 * @package Zdrojowa\AuthenticationLink\Http\Controllers
 */
class AuthenticationLinkController extends Controller
{

    /**
     * @param Request $request
     * @param AuthenticationLinkContract $authenticationLink
     * @param string $token
     *
     * @return RedirectResponse
     */
    public function login(Request $request, AuthenticationLinkContract $authenticationLink, string $token): RedirectResponse
    {
        try {
            $authenticationLink->login($token);
        } catch (TokenNotFoundException | TokenBadSystemCodeException | TokenExpiredException $exception) {
            report($exception);

            return $authenticationLink->getFailedRedirect();
        }

        return $authenticationLink->getSuccessRedirect();
    }
}
