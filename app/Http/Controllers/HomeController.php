<?php

namespace App\Http\Controllers;

use App\Farmer;
use App\Inventory;
use App\Loan;
use App\LoanProvider;
use App\LoanType;
use App\MarketPlace;
use App\ReverseBidding;
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
        if (auth()->user()->hasRole('bfar')){
            return view('trace.bfar.dashboard');
        }

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
        $spotMarketList = auth()->user()->farmer->spotMarket->where('expiration_time','<',Carbon::parse())->pluck('id')->toArray();
        $spotMarketBidsWinsQuery = SpotMarketBid::query();
        $spotMarketBidsWinsQuery = $spotMarketBidsWinsQuery->Where('winner', 1);
        $spotMarketBidsWinsQuery = $spotMarketBidsWinsQuery->WhereIn('spot_market_id', $spotMarketList);
        $spotMarketBidsWins = $spotMarketBidsWinsQuery->pluck('spot_market_id')->toArray();

        $spotMarketWinningBids = SpotMarket::whereIn('id', $spotMarketBidsWins)->get();


        $products = ReverseBidding::where('status', 1)->get();


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
            'spotMarketWinningBids',
            'products'
        ));

    }

}
