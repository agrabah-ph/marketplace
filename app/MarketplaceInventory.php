<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketplaceInventory extends Model
{
    //
    protected $fillable = [
        'user_id',
        'remarks',
        'market_place_id',
        'quantity',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
