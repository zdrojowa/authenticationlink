<?php

namespace Zdrojowa\AuthenticationLink\Observers;

use Zdrojowa\AuthenticationLink\Models\AuthenticationLink;
use Zdrojowa\AuthenticationLink\Support\AuthenticationLinkHelper;
use Illuminate\Support\Str;

/**
 * Class AuthenticationLinkObserver
 * @package Zdrojowa\AuthenticationLink\Observers
 */
class AuthenticationLinkObserver
{
    /**
     * AuthenticationLinkObserver constructor.
     *
     * @param AuthenticationLinkHelper $authenticationLinkHelper
     */
    public function __construct(AuthenticationLinkHelper $authenticationLinkHelper)
    {
        $this->helper = $authenticationLinkHelper;
    }

    /**
     * @param AuthenticationLink $authenticationLink
     */
    public function creating(AuthenticationLink $authenticationLink)
    {
        $authenticationLink->token = $this->helper->generateToken();
    }
}
