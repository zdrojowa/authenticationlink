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

    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) return true;

        return $this->whereHas('packages.permissions', function($query) {
            $query->where('anchor', 'xd');
            $query->where('system_id', AuthenticationLinkFacade::currentSystem());
        })->exists();
    }

    public function isAdmin(): bool {
        return $this->admin;
    }

}
