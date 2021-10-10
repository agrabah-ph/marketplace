<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketplaceOrderStatus extends Model
{
    //
    protected $fillable = [
        'market_place_order_id',
        'status',
        'is_current',
    ];


    public function getNameAttribute()
    {
        $text = "";
        switch ($this->status){
            case 'new':
                $text = "Order Placed";
                break;
            case 'payment_verified':
                $text = "Payment Verified";
                break;
            case 'approved':
                $text = "Order Approved";
                break;
            case 'delivery':
                $text = "On Delivery";
                break;
            case 'delivered':
                $text = "Delivered";
                break;
        }
        return $text;
    }
}
