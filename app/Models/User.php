<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
protected $fillable = [
    'name', 'phone', 'email', 'password', 'role_id', 'region_id', 'is_approved', 'subscription_until',
];

// Function ya kuangalia kama subscription bado ni valid
public function hasActiveSubscription()
{
    // Kama ni Admin (Role 1 au 2), mruhusu tu
    if (in_array($this->role_id, [1, 2])) return true;

    // Kama hana tarehe au tarehe imepita sasa hivi
    if (!$this->subscription_until || $this->subscription_until->isPast()) {
        return false;
    }

    return true;
}



    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    // Hakikisha tarehe inasomwa kama Carbon object
    protected $casts = [
        'email_verified_at' => 'datetime',
        'subscription_until' => 'datetime', // Ongeza hii
    ];
}
