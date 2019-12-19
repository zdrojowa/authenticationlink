<?php

namespace Zdrojowa\AuthenticationLink\Traits;

use Zdrojowa\AuthenticationLink\Facades\AuthenticationLink as AuthenticationLinkFacade;

/**
 * Trait hasSpecificConnection
 * @package Zdrojowa\AuthenticationLink\Traits
 */
trait hasSpecificConnection
{
    /**
     * @return mixed
     */
    public function getConnectionName()
    {
        return AuthenticationLinkFacade::getConnectionName();
    }
}
