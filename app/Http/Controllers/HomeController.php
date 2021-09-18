<?php

namespace App\Http\Controllers;

use App\Farmer;
use App\Inventory;
use App\Loan;
use App\LoanProvider;
use App\LoanType;
use App\MarketPlace;
use App\MarketPlaceBid;
use App\ReverseBidding;
use App\ReverseBiddingBid;
use App\SpotMarket;
use App\SpotMarketBid;
use App\Trace;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $marketplace = MarketPlace::get();
        $marketplaceIncome = 0;

        /** COUNTS */
        $productCount = [
            'monthly' => 0,
            'weekly' => 0,
            'today' => 0,
        ];
        
        $queryDate = [now()->startOfMonth(), now()->endOfMonth()];
        $marketplaceCountMonth = MarketPlace::whereBetween('created_at', $queryDate)->count();
        $spotMarketCountMonth = SpotMarket::whereBetween('created_at', $queryDate)->count();
        $reverseBiddingCountMonth = ReverseBidding::whereBetween('created_at', $queryDate)->count();
        $productCount['monthly'] = $marketplaceCountMonth + $spotMarketCountMonth + $reverseBiddingCountMonth;

        $queryDate = [now()->weekday(0)->startOfDay(), now()->weekday(6)->endOfDay()];
        $marketplaceCountWeek = MarketPlace::whereBetween('created_at', $queryDate)->count();
        $spotMarketCountWeek = SpotMarket::whereBetween('created_at', $queryDate)->count();
        $reverseBiddingCountWeek = ReverseBidding::whereBetween('created_at', $queryDate)->count();
        $productCount['weekly'] = $marketplaceCountWeek + $spotMarketCountWeek + $reverseBiddingCountWeek;

        $queryDateToday = [now()->startOfDay(), now()->endOfDay()];
        $marketplaceCountToday = MarketPlace::whereBetween('created_at', $queryDateToday)->count();
        $spotMarketCountToday = SpotMarket::whereBetween('created_at', $queryDateToday)->count();
        $reverseBiddingCountToday = ReverseBidding::whereBetween('created_at', $queryDateToday)->count();
        $productCount['today'] = $marketplaceCountToday + $spotMarketCountToday + $reverseBiddingCountToday;
        /** COUNTS */


        /** BIDS */
        $winningBids = [];
        $winningBidsMarketplace = [];
        $winningBidsReverseBidding = [];
        $products = [];
        $isCommunityLeader = false;
        if(auth()->user()->farmer){
            if(isCommunityLeader()){
                $spotMarketList = auth()->user()->farmer->spotMarket->where('expiration_time','<',Carbon::parse())->pluck('id')->toArray();

                $spotMarketBidsWinsQuery = SpotMarketBid::query();
                $spotMarketBidsWinsQuery = $spotMarketBidsWinsQuery->Where('winner', 1);
                $spotMarketBidsWinsQuery = $spotMarketBidsWinsQuery->WhereIn('spot_market_id', $spotMarketList);
                $spotMarketBidsWins = $spotMarketBidsWinsQuery->pluck('spot_market_id')->toArray();

                $winningBids = SpotMarket::whereIn('id', $spotMarketBidsWins)->get();

                $marketplaceList = auth()->user()->farmer->marketPlace->where('expiration_time','<',Carbon::parse())->pluck('id')->toArray();

                $marketplaceBidsWinsQuery = MarketPlaceBid::query();
                $marketplaceBidsWinsQuery = $marketplaceBidsWinsQuery->Where('winner', 1);
                $marketplaceBidsWinsQuery = $marketplaceBidsWinsQuery->WhereIn('market_place_id', $marketplaceList);
                $marketplaceBidsWins = $marketplaceBidsWinsQuery->pluck('market_place_id')->toArray();

                $winningBidsMarketplace = MarketPlace::whereIn('id', $marketplaceBidsWins)->get();

                $reverseBiddingQuery = ReverseBiddingBid::query();
                $reverseBiddingQuery = $reverseBiddingQuery->Where('winner', 1);
                $reverseBiddingQuery = $reverseBiddingQuery->where('user_id', auth()->user()->id);
                $reverseBiddingBidsWins = $reverseBiddingQuery->pluck('reverse_bidding_id')->toArray();

                $winningBidsReverseBidding = ReverseBidding::whereIn('id', $reverseBiddingBidsWins)->get();

                $products = ReverseBidding::where('status', 0)->where('expiration_time', '>', now())->get();
                $isCommunityLeader = true;
            }
        }
        $myBidsSpotMarket = [];
        $myBidsMarketplace = [];
        if(!$products){
            $spotMarketBidsActiveQuery = SpotMarketBid::query();
//            $spotMarketBidsActiveQuery = $spotMarketBidsActiveQuery->Where('user_id', auth()->user()->id);
            $spotMarketBidsActive = $spotMarketBidsActiveQuery->pluck('spot_market_id')->toArray();

            $myBidsSpotMarket = SpotMarket::whereIn('id', $spotMarketBidsActive)
                ->get();

            $spotMarketBidsActiveQuery = MarketPlaceBid::query();
//            $spotMarketBidsActiveQuery = $spotMarketBidsActiveQuery->Where('user_id', auth()->user()->id);
            $spotMarketBidsActive = $spotMarketBidsActiveQuery->pluck('market_place_id')->toArray();

            $myBidsMarketplace = MarketPlace::whereIn('id', $spotMarketBidsActive)
                ->get();

        }


        /** BIDS */

        return view('wharf.dashboard', compact(
            'marketplaceIncome',
            'marketplaceCountMonth',
            'spotMarketCountMonth',
            'reverseBiddingCountMonth',
            'marketplaceCountWeek',
            'spotMarketCountWeek',
            'reverseBiddingCountWeek',
            'marketplaceCountToday',
            'spotMarketCountToday',
            'reverseBiddingCountToday',
            'isCommunityLeader',
            'myBidsSpotMarket',
            'myBidsMarketplace',
            'winningBids',
            'winningBidsMarketplace',
            'winningBidsReverseBidding',
            'products'
        ));

    }

}
