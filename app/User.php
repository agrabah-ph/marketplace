<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'passkey',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function farmer()
    {
        return $this->hasOne(Farmer::class, 'user_id', 'id')->with('profile');
    }

    public function leader()
    {
        return $this->hasOne(Farmer::class, 'user_id', 'id')->with('profile');
    }

    public function loan_provider()
    {
        return $this->hasOne(LoanProvider::class, 'user_id', 'id')->with('profile');
    }

    public function mySpotMarketList()
    {
        return $this->morphMany(SpotMarket::class, 'model');
    }

    public function spotMarketCart()
    {
        return $this->hasMany(SpotMarketCart::class, 'user_id');
    }
}
