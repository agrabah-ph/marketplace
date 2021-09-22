<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class MarketplaceOrderPayment extends Model implements HasMedia
{
    use HasMediaTrait;
    //
    protected $fillable = [
        'market_place_order_id',
        'payment_date',
        'reference_number',
    ];
}
