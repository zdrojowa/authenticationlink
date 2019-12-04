<?php

namespace Zdrojowa\AuthenticationLink\Traits;

use Zdrojowa\AuthenticationLink\Facades\AuthenticationLink as AuthenticationLinkFacade;
use Zdrojowa\AuthenticationLink\Models\AuthenticationLink;

/**
 * Trait hasAuthenticationLink
 * @package Zdrojowa\AuthenticationLink\Traits
 */
trait hasAuthenticationLink
{
    /**
     * @return mixed
     */
    public function authenticationLinks()
    {
        return $this->hasMany(AuthenticationLink::class);
    }

    /**
     * @param int $systemId
     */
    public function createAuthenticationLink(int $systemId)
    {
        AuthenticationLinkFacade::create($this->id, $systemId);
    }
}
