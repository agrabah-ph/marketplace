<?php

namespace App\Http\Controllers;

use App\Farmer;
use App\Http\Resources\SpotMarketBrowseCollection;
use App\Loan;
use App\Services\LoanService;
use App\Services\SpotMarketOrderService;
use App\MarketPlace;
use App\MarketPlaceBid;
use App\SpotMarketCart;
use App\SpotMarketOrder;
use App\SpotMarketPayment;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MarketPlaceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myBids()
    {
        $spotMarketBidsActiveQuery = MarketPlaceBid::query();
        $spotMarketBidsActiveQuery = $spotMarketBidsActiveQuery->Where('user_id', auth()->user()->id);
        $spotMarketBidsActive = $spotMarketBidsActiveQuery->pluck('market_place_id')->toArray();

        $activeBids = MarketPlace::whereIn('id', $spotMarketBidsActive)
            ->where('expiration_time', '>',now())
            ->get();

        $spotMarketBidsWinsQuery = MarketPlaceBid::query();
        $spotMarketBidsWinsQuery = $spotMarketBidsWinsQuery->Where('user_id', auth()->user()->id);
        $spotMarketBidsWinsQuery = $spotMarketBidsWinsQuery->Where('winner', 1);
        $spotMarketBidsWins = $spotMarketBidsWinsQuery->pluck('market_place_id')->toArray();

        $winningBids = MarketPlace::whereIn('id', $spotMarketBidsWins)
            ->where('expiration_time', '<',now())
            ->get();

        $spotMarketBidsLoseQuery = MarketPlaceBid::query();
        $spotMarketBidsLoseQuery = $spotMarketBidsLoseQuery->Where('user_id', auth()->user()->id);
        $spotMarketBidsLoseQuery = $spotMarketBidsLoseQuery->Where('winner', 0);
        $spotMarketBidsLose = $spotMarketBidsLoseQuery->pluck('market_place_id')->toArray();
        $losingBids = MarketPlace::whereIn('id', $spotMarketBidsLose)
            ->where('expiration_time', '<',now())
            ->whereNotIn('id', $winningBids)
            ->get();

        return view('wharf.market-place.my_bids', compact('activeBids', 'winningBids', 'losingBids'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function winningBids()
    {
        $spotMarketList = auth()->user()->farmer->spotMarket->where('expiration_time','<',Carbon::parse())->pluck('id')->toArray();

        $spotMarketBidsWinsQuery = MarketPlaceBid::query();
        $spotMarketBidsWinsQuery = $spotMarketBidsWinsQuery->Where('winner', 1);
        $spotMarketBidsWinsQuery = $spotMarketBidsWinsQuery->WhereIn('market_place_id', $spotMarketList);
        $spotMarketBidsWins = $spotMarketBidsWinsQuery->pluck('market_place_id')->toArray();

        $winningBids = MarketPlace::whereIn('id', $spotMarketBidsWins)->get();

        return view('wharf.market-place.winning_bids', compact('winningBids'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function completeBid(Request $request)
    {
        $spotMarket = MarketPlace::find($request->id);
        $method = $request->input('method');
        $spotMarket->method = $method;
        $spotMarket->status = 1;
        $spotMarket->save();

        return redirect()->back();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $spotMarketList = [];

        $roleName = auth()->user()->roles->first()->name;
        $isCommunityLeader = false;
        if($roleName == 'farmer'){
            if(isCommunityLeader()){
                $spotMarketList = auth()->user()->farmer->marketPlace;
                $isCommunityLeader = true;
                return view('wharf.market-place.index', compact('spotMarketList', 'isCommunityLeader'));
            }
        }
        $spotMarketList = MarketPlace::when($request->area,function($q) use ($request){
            if($request->area != '_all'){
                $q->where('area',$request->area);
            }
        })->where('expiration_time','>=',Carbon::now())->get();
        $areas = MarketPlace::distinct('area')->pluck('area')->toArray();
        return view('wharf.market-place.browse', compact('spotMarketList', 'isCommunityLeader', 'areas'));

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $farmers = Farmer::with('user')->where('community_leader', 0)->get();
        $defaultAreaQuery = Farmer::where('user_id', auth()->user()->id)->first()->marketPlace;
        $defaultAreaQuery = $defaultAreaQuery->whereNotNull('area')->first();
        $defaultArea = "";
        if($defaultAreaQuery){
            $defaultArea = $defaultAreaQuery->area;
        }

        return view('wharf.market-place.create', compact('farmers', 'defaultArea'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBid(Request $request)
    {
        $spotMarketBid = MarketPlace::find($request->id);
        $current_bid = $spotMarketBid->current_bid;
        $bids = $spotMarketBid->bids;
        $value = floatval(preg_replace('/,/','',$request->value));

        if(count($bids) > 0){
            $current_bid = $bids->first()->bid;
            $current_bid+=settings('spot_market_next_bid');
        }

        if($current_bid > $value){
            return response()->json(['status' => false,'$current_bid'=>$current_bid,'value'=>$value]);
        }

        $spotMarketBid = new MarketPlaceBid();
        $spotMarketBid->market_place_id = $request->id;
        $spotMarketBid->user_id = $request->user()->id;
        $spotMarketBid->bid = $request->value;
        $spotMarketBid->save();

        $nextBid = $request->value + settings('spot_market_next_bid');

        $bids = MarketPlaceBid::where('market_place_id', $request->id)->orderBy('bid','desc')->pluck('bid')->toArray();

        event(new \App\Events\UpdateBidBrowse('market-place',$request->id));

        return response()->json(['status' => true, 'bids' => $bids, 'next_bid' => $nextBid, '$current_bid'=>$current_bid, 'value'=>$value]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshBid(Request $request)
    {

        $array = $request->all();

        $spotMarketBid = MarketPlace::find($request->id);
        $current_bid = $spotMarketBid->current_bid;

        $value = floatval(preg_replace('/,/','',$current_bid));

        $nextBid = $value + settings('spot_market_next_bid');

        $bids = MarketPlaceBid::where('market_place_id', $request->id)->orderBy('bid','desc')->pluck('bid');

        return response()->json(['status' => true, 'bids' => $bids, 'next_bid' => $nextBid, 'current_bid'=>$current_bid, 'value'=>$value]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'quantity' => 'numeric|max:1000000',
            'selling_price' => 'regex:/^[0-9]{1,3}(,[0-9]{3})*(\.[0-9]+)*$/',
        ]);


        $roleName = auth()->user()->roles->first()->name;
        $array = $request->except('_token');
        if($roleName == 'farmer'){
            $farmerModel = auth()->user()->farmer;

            $array = array_merge($array,[
                'model_id' => $farmerModel->id,
                'model_type' => 'App\Farmer',
            ]);
            $array["original_price"] = preg_replace('/,/','', $array['selling_price']);
            $array["selling_price"] = preg_replace('/,/','', $array['selling_price']);

            $spotMarket = MarketPlace::create($array);

            $expiration = Carbon::parse($spotMarket['created_at']);
            if($spotMarket['duration']){
                $duration = explode(':',$spotMarket['duration']);
                $expiration->addDays($request->days);
                $expiration->addHour($duration[0]);
                $expiration->addMinute($duration[1]);
                $expiration->second(0);
            }
            $spotMarket->expiration_time = $expiration;
            $spotMarket->save();
            $spotMarket->addMedia($request->file('image'))
                ->toMediaCollection('market-place');
            $farmerModel->marketPlace()->save($spotMarket);
        }

        return redirect()->route('market-place.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = MarketPlace::find($id);
        return view('wharf.market-place.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = MarketPlace::find($id);
        $farmers = Farmer::with('user')->where('community_leader', 0)->get();

        return view('wharf.market-place.edit', compact('data','farmers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'numeric|max:1000000',
            'selling_price' => 'regex:/^[0-9]{1,3}(,[0-9]{3})*(\.[0-9]+)*$/',
        ]);

        $data = MarketPlace::find($id);
        $request->merge([
            'selling_price' => preg_replace('/,/','',$request->selling_price)
        ]);
        $data->update($request->except(['_token', 'image']));

        $expiration = Carbon::parse($data['created_at']);
        if($data['duration']){
            $duration = explode(':',$data['duration']);
            $expiration->addDays($request->days);
            $expiration->addHour($duration[0]);
            $expiration->addMinute($duration[1]);
            $expiration->second(0);
        }
        $data->expiration_time = $expiration;
        $data->save();
        if($request->hasFile('image')){
            $media = $data->getFirstMedia('market-place');
            if($media){
                $media->delete();
            }
            $data->addMedia($request->file('image'))->toMediaCollection('market-place');
        }

        return redirect()->back();
    }

    public function destroy()
    {
        //
    }

    public function lockInOrder(Request $request)
    {

        $formStringify = $request->input('form');
        $form = json_decode($formStringify,true);
        DB::beginTransaction();
        $orderNumber = sprintf('%08d', SpotMarketOrder::count()+1);
        foreach($form as $row){
            $spotMarketOrder = new SpotMarketOrder();
            $spotMarketOrder->order_number = $orderNumber;
            $spotMarketOrder->market_place_id = $row['id'];
            $spotMarketOrder->user_id = auth()->user()->id;
            $spotMarketOrder->quantity = $row['qty'];
            $spotMarketOrder->price = $row['price'];
            $spotMarketOrder->sub_total = $row['sub_total'];
            if($spotMarketOrder->save()){
                $cart = SpotMarketCart::find($row['cart_id']);
                if($cart){
                    $cart->delete();
                    $this->spotMarketOrderService->newOrder($spotMarketOrder);
                }else{
                }
            }else{
            }
        }

        DB::commit();

    }

    public function verifyPayment(Request  $request)
    {
        $request->validate([
            'proof_of_payment' => 'max:10000',
        ],[
            'proof_of_payment.max' => 'Proof of Payment Must be less than 10MB'
        ]);

        $orders = SpotMarketOrder::where('order_number', $request->order_number)->first();
        if($orders){
            $payment = new SpotMarketPayment();
            $payment->order_number = $request->order_number;
            $payment->payment_date = $request->paid_date;
            $payment->reference_number = $request->reference_number;
            $payment->save();
            $payment->addMedia($request->file('proof_of_payment'))
                ->toMediaCollection('market-place-proof-payment');

            $this->spotMarketOrderService->verified($orders);

        }
        return redirect()->back()->with('success','Payment Verified!');
    }

}
