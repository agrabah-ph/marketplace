<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpotMarketCart extends Model
{
    //
    protected $fillable = [
        'user_id',
        'spot_market_id',
        'quantity',
    ];

    public function spotMarket()
    {
        $this->belongsTo(SpotMarket::class, 'spot_market_id');
    }
}
