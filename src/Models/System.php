<?php

namespace Zdrojowa\AuthenticationLink\Models;

use Illuminate\Database\Eloquent\Model;
use Zdrojowa\AuthenticationLink\Traits\hasSpecificConnection;

class System extends Model
{
    use hasSpecificConnection;

    protected $fillable = [
        'name',
        'code',
        'login_url'
    ];
}
