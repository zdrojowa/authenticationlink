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
        'login_url'
    ];

    protected $hidden = [
        'code'
    ];

    public function setCodeAttribute($value) {
        $this->attributes['code'] = Hash::make($value);
    }
}
