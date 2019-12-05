<?php

namespace Zdrojowa\AuthenticationLink\Models;

use Illuminate\Database\Eloquent\Model;
use Zdrojowa\AuthenticationLink\Traits\hasSpecificConnection;

class UserData extends Model
{
    use hasSpecificConnection;


    public function user() {
        return $this->belongsTo('App\User');
    }
}
