<?php

namespace Zdrojowa\AuthenticationLink\Contracts;

use Illuminate\Database\Eloquent\Model;

/**
 * Interface AuthenticationLinkContract
 * @package Zdrojowa\AuthenticationLink\Contracts
 */
interface AuthenticationLinkContract
{
    /**
     * @param int $user
     * @param int $systemId
     * @param int $lifeTime
     *
     * @return string
     */
    public function create(int $user, int $systemId, int $lifeTime = (1000 * 60)): string;

    /**
     * @param int $linkId
     *
     * @return bool
     */
    public function delete(int $linkId): bool;

    /**
     * @return bool
     */
    public function deleteAll(): bool;

    /**
     * @return Model|null
     */
    public function getUserModel(): ?Model;

    /**
     * @return Model|null
     */
    public function getSystemModel(): ?Model;

}
