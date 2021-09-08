<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketPlaceBid extends Model
{

    protected $fillable = [
        'marketplace_id',
        'user_id',
        'bid'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
