<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class SpotMarket extends Model implements HasMedia
{
    use HasMediaTrait;
    //
    protected $fillable = [
        'model_id',
        'model_type',
        'name',
        'description',
        'original_price',
        'selling_price',
        'status',
        'from_user_id',
        'area',
        'duration',
        'expiration_time',
        'quantity',
        'method',
        'unit_of_measure',
    ];

    public function fromFarmer()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function spot_market_bids()
    {
        return $this->hasMany(SpotMarketBid::class, 'spot_market_id')->orderBy('bid','desc');
    }


    public function toArray()
    {
        $array = parent::toArray();
        $array['is_expired'] = Carbon::parse($this->expiration_time)->isPast();
        $array['in_minutes'] = null;
        $array['in_hours'] = null;
        $array['unit_of_measure_short'] = $this->getUnitOfMeasureShortAttribute();
        return $array;
    }

    public function getCurrentBidAttribute()
    {
        $bids = SpotMarketBid::where('spot_market_id', $this->id)->orderBy('bid','desc')->first();
        $currentBid = $bids->bid??$this->selling_price;
        return $currentBid;
    }

    public function getInMinutesAttribute()
    {
        $minutes = null;
        if(!$this['is_expired']){
            $minutes = Carbon::now()->diffInMinutes($this->expiration_time);
            $minutes = $minutes >= 60? $minutes-60: $minutes ;
        }
        return $minutes;
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


    public function getIsExpiredAttribute()
    {
        return Carbon::parse($this->expiration_time)->isPast();
    }
}
