<?php

namespace Zdrojowa\AuthenticationLink\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Zdrojowa\AuthenticationLink\Traits\hasSpecificConnection;

class System extends Model
{
    use hasSpecificConnection;

    protected $fillable = [
        'name',
        'code',
        'login_url',
        'synchronization_url',
        'photo'
    ];

    protected $hidden = [
        'code'
    ];

    public function permissions() {
        return $this->hasMany(Permission::class);
    }


    public function setCodeAttribute($value) {
        $this->attributes['code'] = Hash::make($value);
    }
}
