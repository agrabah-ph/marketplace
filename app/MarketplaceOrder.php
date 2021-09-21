<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketplaceOrder extends Model
{
    //
    protected $fillable = [
        'order_number',
        'user_id',
        'quantity',
        'total',
        'sub_total',
        'service_fee',
    ];

    public function items()
    {
        return $this->hasmany(MarketplaceOrderItem::class, 'market_place_order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment()
    {
        return $this->hasOne(MarketplaceOrderPayment::class,'market_place_order_id');
    }

    public function status()
    {
        return $this->hasOne(MarketplaceOrderStatus::class,'market_place_order_id')->where('is_current',1);
    }
    public function statuses()
    {
        return $this->hasMany(MarketplaceOrderStatus::class,'market_place_order_id');
    }
}
