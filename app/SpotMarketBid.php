<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotMarketBid extends Model
{
    //
    protected $fillable = [
        'spot_market_id',
        'user_id',
        'bid'
    ];
}
