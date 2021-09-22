<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketplaceHistory extends Model
{
    //
    protected $fillable = [
        'market_place_id',
        'user_id',
        'action',
    ];
}
