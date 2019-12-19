<?php

namespace Zdrojowa\AuthenticationLink\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static getSystemModel(): ?Model
 * @method static getUserModel(): ?Model
 * @method static canMigrate()
 * @method static getConnectionName()
 * @method static create($id, int $systemId)
 */
class AuthenticationLink extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'authentication_link';
    }

}
