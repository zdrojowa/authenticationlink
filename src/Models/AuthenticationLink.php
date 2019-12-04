<?php

namespace Zdrojowa\AuthenticationLink\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class AuthenticationLink extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'system_id',
        'token',
        'expired_at',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'expired_at' => 'datetime',
    ];
}
