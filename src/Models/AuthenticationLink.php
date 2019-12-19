<?php

namespace Zdrojowa\AuthenticationLink\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Zdrojowa\AuthenticationLink\Facades\AuthenticationLink as AuthenticationLinkFacade;
use Zdrojowa\AuthenticationLink\Traits\hasSpecificConnection;

/**
 * @method static create(array $array)
 * @method static where(string $string, string $token)
 * @property int system
 */
class AuthenticationLink extends Model
{
    use hasSpecificConnection;
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

    /**
     * @return BelongsTo
     */
    public function system()
    {
        return $this->belongsTo('Zdrojowa\AuthenticationLink\Models\System');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Zdrojowa\AuthenticationLink\Models\User');
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeNonExpired($query)
    {
        return $query->whereDate('expired_at', '>', Carbon::now());
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeExpired($query)
    {
        return $query->whereDate('expired_at', '<', Carbon::now());
    }

    /**
     * @return bool
     */
    public function isExpired()
    {
        return ($this->expired_at < Carbon::now());
    }

}
