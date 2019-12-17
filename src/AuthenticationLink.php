<?php

namespace Zdrojowa\AuthenticationLink;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Zdrojowa\AuthenticationLink\Contracts\AuthenticationLinkContract;
use Zdrojowa\AuthenticationLink\Exceptions\TokenBadSystemCodeException;
use Zdrojowa\AuthenticationLink\Exceptions\TokenExpiredException;
use Zdrojowa\AuthenticationLink\Exceptions\TokenNotFoundException;
use Zdrojowa\AuthenticationLink\Models\AuthenticationLink as AuthenticationLinkModel;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Zdrojowa\AuthenticationLink\Models\System;

/**
 * Class AuthenticationLink
 * @package Zdrojowa\AuthenticationLink
 */
class AuthenticationLink implements AuthenticationLinkContract
{

    /**
     * @var Model|null
     */
    private ?Model $userModel;

    /**
     * @var Model|null
     */
    private ?Model $systemModel;

    private string $systemCode;

    private bool $migrations;

    private int $lifetime;

    private string $failedRedirectLink;

    private string $successRedirectLink;

    private string $connectionName;

    /**
     * AuthenticationLink constructor.
     */
    public function __construct()
    {
        $this->systemCode = Config::get('authentication-link.system_code');
        $this->successRedirectLink = Config::get('authentication-link.success_redirect_link');
        $this->failedRedirectLink = Config::get('authentication-link.failed_redirect_link');
        $this->migrations = Config::get('authentication-link.migrations');
        $this->lifetime = Config::get('authentication-link.token.lifetime');
        $this->connectionName = Config::get('authentication-link.database_connection');

        try {
            $this->userModel = app()->make(Config::get('authentication-link.user_model'));
        } catch (BindingResolutionException $e) {
            $this->userModel = null;
        }

        try {
            $this->systemModel = app()->make(Config::get('authentication-link.system_model'));
        } catch (BindingResolutionException $e) {
            $this->systemModel = null;
        }
    }

    /**
     * @param int $user
     * @param int $systemId
     * @param int|null $lifeTime
     *
     * @return string
     */
    public function create(int $user, int $systemId, int $lifeTime = null): ?string
    {
        if ($this->systemModel && $this->userModel && $this->userModel->query()->where('id', $user)->exists() && $this->systemModel instanceof Model) {
            $system = $this->systemModel->findOrFail($systemId);

            return AuthenticationLinkModel::create([
                'user_id' => $user,
                'system_id' => $systemId,
                'expired_at' => Carbon::now()->addSeconds($lifeTime ?? Config::get('authentication-link.token.lifetime')),
            ])->token;
        }

        return null;
    }

    /**
     * @param int $linkId
     *
     * @return bool
     */
    public function delete(int $linkId): bool
    {
        // TODO: Implement delete() method.
    }

    /**
     * @return bool
     */
    public function deleteAll(): bool
    {
        // TODO: Implement deleteAll() method.
    }

    /**
     * @return Model|null
     */
    public function getUserModel(): ?Model
    {
        return $this->userModel;
    }

    /**
     * @return Model|null
     */
    public function getSystemModel(): ?Model
    {
        return $this->systemModel;
    }

    /**
     * @param string $token
     *
     * @return bool
     * @throws TokenBadSystemCodeException
     * @throws TokenExpiredException
     * @throws TokenNotFoundException
     */
    public function login(string $token): bool
    {
        $tokenModel = AuthenticationLinkModel::where('token', $token)->with('system')->with('user')->first();

        if (!$this->exists($tokenModel)) throw new TokenNotFoundException($token);
        if (!$this->correctSystemCode($tokenModel)) throw new TokenBadSystemCodeException($token);
        if ($tokenModel->isExpired()) throw new TokenExpiredException($token);

        Auth::loginUsingId($tokenModel->user_id);

        $tokenModel->delete();

        return Auth::check();
    }

    private function exists($token): bool
    {
        return $token ? true : false;
    }

    private function correctSystemCode(AuthenticationLinkModel $token): bool
    {
        return Hash::check($this->systemCode, $token->system->code);
    }

    public function getSuccessRedirect(): RedirectResponse
    {
        return redirect($this->successRedirectLink);
    }

    public function getFailedRedirect(): RedirectResponse
    {
        return redirect($this->failedRedirectLink);
    }

    public function canMigrate(): bool
    {
        return $this->migrations;
    }

    public function getConnectionName(): string
    {
        return $this->connectionName;
    }

    public function getSystemCode() {
        return $this->systemCode;
    }

    public function currentSystem(): ?System {
        foreach ($this->systemModel->all() as $system) {
            if(Hash::check($this->systemCode, $system->code)) return $system;
        }

        return null;
    }
}
