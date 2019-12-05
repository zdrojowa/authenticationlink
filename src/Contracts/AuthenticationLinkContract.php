<?php

namespace Zdrojowa\AuthenticationLink\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;

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
    public function create(int $user, int $systemId, int $lifeTime = null): ?string;

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
     * @return bool
     */
    public function canMigrate(): bool;

    /**
     * @return Model|null
     */
    public function getSystemModel(): ?Model;

    /**
     * @param string $token
     *
     * @return bool
     */
    public function login(string $token): bool;

    /**
     * @return RedirectResponse
     */
    public function getSuccessRedirect(): RedirectResponse;

    /**
     * @return RedirectResponse
     */
    public function getFailedRedirect(): RedirectResponse;

    /**
     * @return string
     */
    public function getConnectionName(): string;
}
