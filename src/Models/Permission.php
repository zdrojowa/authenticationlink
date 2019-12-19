<?php

namespace Zdrojowa\AuthenticationLink\Models;

use Illuminate\Database\Eloquent\Model;
use Zdrojowa\AuthenticationLink\Traits\hasSpecificConnection;

class Permission extends Model
{
    use hasSpecificConnection;

    protected $fillable = [
        'anchor',
        'parent_id',
        'synchronized',
        'name',
        'system_id',
    ];

    public function system()
    {
        $this->belongsTo(System::class, 'system_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Permission::class, 'parent_id', 'id')->with('children');
    }

    public function parent()
    {
        return $this->hasOne(Permission::class, 'id', 'parent_id')->with('parent');
    }

    public function packages()
    {
        $this->belongsToMany(PermissionPackage::class, 'perm_package', 'permission_id', 'permission_package_id');
    }

}
