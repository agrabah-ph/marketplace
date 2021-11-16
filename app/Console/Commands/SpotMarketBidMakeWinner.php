<?php

namespace App\Console\Commands;

use App\Mail\WinningNotification;
use App\MarketPlace;
use App\ReverseBidding;
use App\ReverseBiddingOffers;
use App\Settings;
use App\SpotMarket;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SpotMarketBidMakeWinner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spotmarket:award_winners';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'spot market make winner';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $spotMarkets = SpotMarket::where('expiration_time','<', Carbon::now())->get();
        foreach($spotMarkets as $spotMarket){
            if(Carbon::parse($spotMarket->expiration_time)->isPast()){
                $winningBid = $spotMarket->spot_market_bids->first();
                if($winningBid){
                    if($winningBid->winner == 0){
                        Mail::to($winningBid->user->email)->send(new WinningNotification(['name'=>$spotMarket->name, 'price' => $winningBid->bid]));
                        $winningBid->winner = 1;
                        $winningBid->save();
                    }
                }
//                $spotMarket->status = 1;
//                $spotMarket->save();
            }
        }
        $this->info('Generating Spot market Winners');
        Log::info('Generating Spot market Winners');

//        $spotMarkets = MarketPlace::where('expiration_time','<', Carbon::now())->get();
//        foreach($spotMarkets as $spotMarket){
//            if(Carbon::parse($spotMarket->expiration_time)->isPast()){
//                $winningBid = $spotMarket->bids->first();
//                if($winningBid){
//                    $winningBid->winner = 1;
//                    $winningBid->save();
//                }
////                $spotMarket->status = 1;
////                $spotMarket->save();
//            }
//        }
//        $this->info('Generating Marketplace Winners');
//        Log::info('Generating Marketplace Winners');

        $spotMarkets = ReverseBidding::where('expiration_time','<', Carbon::now())->get();
        foreach($spotMarkets as $spotMarket){
            if(Carbon::parse($spotMarket->expiration_time)->isPast()){
                if($spotMarket->status == 0){
                    if($spotMarket->lowest_bid){
                        $offer = ReverseBiddingOffers::find($spotMarket->lowest_bid->id);
                        if($offer->winner == 0){
                            Mail::to($spotMarket->lowest_bid->user->email)->send(new WinningNotification(['name'=>$spotMarket->lowest_bid->user->email, 'price' => $spotMarket->total_bid]));
                            $spotMarket->lowest_bid->winner = 1;
                            $offer->winner = 1;
                            $offer->save();
                        }
                    }
                }

//                $winningBid = $spotMarket->bids->first();
//                if($winningBid){
//                    if($winningBid->winner == 0){
//                        Mail::to($winningBid->user->email)->send(new WinningNotification(['name'=>$spotMarket->name, 'price' => $winningBid->bid]));
//                        $winningBid->winner = 1;
//                        $winningBid->save();
//                    }
//                }
//                $spotMarket->status = 1;
//                $spotMarket->save();
            }
        }
        $this->info('Generating Reverse Bidding Winners');
        Log::info('Generating Reverse Bidding Winners');
    }
}
