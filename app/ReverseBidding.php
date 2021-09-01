<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class ReverseBidding extends Model implements HasMedia
{
    //
    use HasMediaTrait;

    protected $fillable= [
        'po_num',
        'user_id',
        'name',
        'description',
        'quantity',
        'duration',
        'expiration_time',
        'asking_price',
        'buying_price',
        'area',
        'method',
        'status',
        'unit_of_measure',
    ];

    public function bids()
    {
        return $this->hasMany(ReverseBiddingBid::class, 'reverse_bidding_id')->orderBy('bid','desc');
    }

    public function getCurrentBidAttribute()
    {
        $bids = ReverseBiddingBid::where('reverse_bidding_id', $this->id)->orderBy('bid','desc')->first();
        $currentBid = $bids->bid??$this->asking_price;
        return $currentBid;
    }

}
