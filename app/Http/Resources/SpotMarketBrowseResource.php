<?php

namespace App\Http\Resources;

use App\SpotMarketBid;
use Illuminate\Http\Resources\Json\JsonResource;

class SpotMarketBrowseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $array = parent::toArray($request);
        $bids = SpotMarketBid::where('spot_market_id', $this->id)->orderBy('bid','desc')->first();
//        $array['current_bid'] = $bids->bid;
        return $array;
    }
}
