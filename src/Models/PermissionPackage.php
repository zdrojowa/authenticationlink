<?php

namespace Zdrojowa\AuthenticationLink\Models;

use Illuminate\Database\Eloquent\Model;
use Zdrojowa\AuthenticationLink\Facades\AuthenticationLink as AuthenticationLinkFacade;
use Zdrojowa\AuthenticationLink\Traits\hasSpecificConnection;

class PermissionPackage extends Model
{
    use hasSpecificConnection;

    protected $fillable = [
        'name'
    ];

    public function permissions() {
        return $this->belongsToMany('App\Permission', 'perm_package', 'permission_package_id', 'permission_id');
    }

    public function users() {
        $this->belongsToMany('App\User', 'users_permissions_packages', 'permission_package_id', 'user_id');
    }
}
