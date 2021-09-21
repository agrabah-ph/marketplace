<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketplaceOrderReview extends Model
{
    //
    protected $fillable = [
        'market_place_order_id',
        'user_id',
        'reviewer_name',
        'rating',
        'comment',
    ];
}
