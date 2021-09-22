<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketplaceCart extends Model
{
    //

    protected $fillable = [
        'user_id',
        'market_place_id',
        'quantity',
    ];
}
