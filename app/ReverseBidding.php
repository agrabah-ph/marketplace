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
        'days',
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

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function getCurrentBidAttribute()
    {
        $bids = ReverseBiddingBid::where('reverse_bidding_id', $this->id)->orderBy('bid','desc')->first();
        $currentBid = $bids->bid??$this->asking_price;
        return $currentBid;
    }

    public function getWinnerAttribute()
    {
        $bids = ReverseBiddingBid::where('reverse_bidding_id', $this->id)->orderBy('bid','desc')->first();
        $user = null;
        if($bids){
            $user = $bids->user;
        }
        return $user;
    }
    public function getUnitOfMeasureShortAttribute()
    {
        $uom = '';
        if($this['unit_of_measure']){
            switch ($this['unit_of_measure']){
                case 'kilos':
                    $uom = 'kg(s)';
                    break;
                case 'bayera':
                    $uom = ' bayera';
                    break;
                case 'lot':
                    $uom = ' lot';
                    break;
                case 'pieces':
                    $uom = 'pc(s)';
                    break;
                default:
                    $uom = $this['unit_of_measure'];
                    break;
            }
        }
        return $uom;
    }

}
