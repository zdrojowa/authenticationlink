<?php

namespace Zdrojowa\AuthenticationLink\Models;

use Illuminate\Database\Eloquent\Model;
use Zdrojowa\AuthenticationLink\Traits\hasSpecificConnection;

class Permission extends Model
{
    use hasSpecificConnection;

    protected $fillable = [
        'name',
        'system_id'
    ];

    public function system() {
        $this->belongsTo('App\System', 'system_id', 'id');
    }

    public function packages() {
        $this->belongsToMany('App\PermissionPackage', 'perm_package', 'permission_id', 'permission_package_id');
    }

}
