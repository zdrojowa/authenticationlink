<?php

namespace Zdrojowa\AuthenticationLink;

use Zdrojowa\AuthenticationLink\Contracts\AuthenticationLinkContract;
use Zdrojowa\AuthenticationLink\Models\AuthenticationLink as AuthenticationLinkModel;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

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

    /**
     * AuthenticationLink constructor.
     */
    public function __construct()
    {
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
    public function create(int $user, int $systemId, int $lifeTime = null): string
    {
        if ($this->systemModel && $this->userModel && User::where('id', $user)->exists() && $this->systemModel instanceof Model) {
            $system = $this->systemModel->findOrFail($systemId);

            return AuthenticationLinkModel::create([
                'user_id' => $user,
                'system_id' => $systemId,
                'expired_at' => Carbon::now()->addMinutes($lifeTime ?? Config::get('authentication-link.token.lifetime')),
            ])->token;
        }

        return '';
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
}
