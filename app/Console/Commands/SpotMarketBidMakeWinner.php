<?php

namespace App\Console\Commands;

use App\Settings;
use App\SpotMarket;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
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
            $this->info($spotMarket->expiration_time);
            if(Carbon::parse($spotMarket->expiration_time)->isPast()){
                $winningBid = $spotMarket->spot_market_bids->first();
                if($winningBid){
                    $winningBid->winner = 1;
                    $winningBid->save();
                }
            }
        }
        $this->info('Generating Winners');
        Log::info('Generating Spot market Winners');
    }
}
