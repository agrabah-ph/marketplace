<?php

namespace App\Http\Controllers;

use App\BfarNotifications;
use App\Exports\BfarReport;
use App\Exports\Report;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

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
    public function index(Request  $request)
    {
        if (auth()->user()->hasRole('bfar')){

            $datas = BfarNotifications::get();

            $row = [];
            $start = Carbon::now()->toDateString();
            $end = Carbon::now()->toDateString();
            if($request->has('mode') && $mode = $request->get('mode')){

                $start = $request->get('start');
                $end = $request->get('end');

                $query = BfarNotifications::query();
                $query->whereBetween('date_of_travel', [$start, $end]);

                $row = $query->get();

                if($mode == 'download'){
                    return Excel::download(new BfarReport($row), Carbon::parse($start)->format('Y-m-d').' to '.Carbon::parse($end)->format('Y-m-d').' Report.xlsx');
                }
            }

            return view('trace.bfar.dashboard',compact('datas','start', 'end'));
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
        $winningBids = [];
        $winningBidsMarketplace = [];
        $winningBidsReverseBidding = [];
        $expiredAuctionResult = [];
        $expiredPo = [];
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

                $marketplaceList = auth()->user()->farmer->marketPlace->where('expiration_time','>',Carbon::parse())->pluck('id')->toArray();

                $marketplaceBidsWinsQuery = MarketPlaceBid::query();
                $marketplaceBidsWinsQuery = $marketplaceBidsWinsQuery->Where('winner', 1);
                $marketplaceBidsWinsQuery = $marketplaceBidsWinsQuery->WhereIn('market_place_id', $marketplaceList);
                $marketplaceBidsWins = $marketplaceBidsWinsQuery->pluck('market_place_id')->toArray();

                $winningBidsMarketplace = MarketPlace::whereIn('id', $marketplaceBidsWins)->get();


                $expiredAuctionResult = auth()->user()->farmer->spotMarket->where('expiration_time','<',Carbon::parse());

                $expiredPo = ReverseBidding::where('expiration_time', '<', now())->get();


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



        $marketList = MarketPlace::query()->with('inventory','categoriesRel')
            ->when($request->area, function($q) use ($request){
                if($request->areas != '_all'){
                    $q->where('area',$request->areas);
                }
            })
            ->when($request->filter, function($q) use ($request){
                $q->where('name', 'like','%'.$request->filter.'%');
            })
            ->when($request->cat, function($q) use ($request){
                if($request->cat != '_all'){
                    $q->whereHas('categoriesRel', function(Builder $builder) use ($request){
                        $builder->where('id', $request->cat);
                    });
                }
            });

        $marketList= $marketList->get();



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
            'expiredAuctionResult',
            'expiredPo',
            'products',
            'marketList'
        ));

    }

}
