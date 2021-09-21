<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketplaceOrderItem extends Model
{
    //
    protected $fillable = [
        'market_place_order_id',
        'market_place_id',
        'price',
        'quantity',
        'total',
    ];

    public function product()
    {
        return $this->belongsTo(MarketPlace::class, 'market_place_id');
    }
}
