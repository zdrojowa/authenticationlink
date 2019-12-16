<?php

namespace Zdrojowa\AuthenticationLink\Models;

use Zdrojowa\AuthenticationLink\Facades\AuthenticationLink as AuthenticationLinkFacade;
use Zdrojowa\AuthenticationLink\Traits\hasAuthenticationLink;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Zdrojowa\AuthenticationLink\Traits\hasSpecificConnection;
use Zdrojowa\AuthenticationLink\Traits\Metable;

class User extends Authenticatable
{
    use Notifiable, hasAuthenticationLink, hasSpecificConnection, Metable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function packages()
    {
        return $this->belongsToMany(PermissionPackage::class, 'users_permissions_packages', 'user_id', 'permission_package_id');
    }

    public function data()
    {
        return $this->hasOne('App\UserData');
    }

    public function getPermissionsAttribute()
    {
        if (!$this->relationLoaded('packages') || !$this->packages->first()->relationLoaded('permissions')) {
            $this->load('packages.permissions');
        }

        return collect($this->packages->pluck('permissions'))->collapse()->unique();
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) return true;

        return Permission
            ::join('perm_package', 'permissions.id', '=', 'perm_package.permission_id')
            ->join('permission_packages', 'perm_package.permission_package_id', '=', 'permission_packages.id')
            ->join('users_permissions_packages', 'permission_packages.id', '=', 'users_permissions_packages.permission_package_id')
            ->join('users', 'users_permissions_packages.user_id', '=', 'users.id')
            ->where('users.id', $this->id)->where('permissions.anchor', $permission)->where('system_id', AuthenticationLinkFacade::currentSystem())->count();
    }

    public function isAdmin(): bool {
        return $this->admin;
    }

}
