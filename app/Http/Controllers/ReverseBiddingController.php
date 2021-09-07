<?php

namespace App\Http\Controllers;

use App\Farmer;
use App\Http\Resources\SpotMarketBrowseCollection;
use App\Loan;
use App\ReverseBidding;
use App\ReverseBiddingBid;
use App\Services\LoanService;
use App\Services\SpotMarketOrderService;
use App\SpotMarket;
use App\SpotMarketBid;
use App\SpotMarketCart;
use App\SpotMarketOrder;
use App\SpotMarketPayment;
use Carbon\Carbon;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReverseBiddingController extends Controller
{

    /**
     * @var LoanService
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $list = [];
        $areas = [];

        $areas = ReverseBidding::whereNotNull('area')->distinct('area')->pluck('area')->toArray();

        $roleName = auth()->user()->roles->first()->name;
        $isCommunityLeader = false;
        if($roleName == 'buyer'){
            $list = auth()->user()->reveseBiddings;
            $isCommunityLeader = true;
            return view('wharf.reverse-bidding.index', compact('list', 'isCommunityLeader', 'areas'));
        }

        $listQuery = ReverseBidding::query();

        $listQuery->when($request->area,function($q) use ($request){
            if($request->area != '_all'){
                $q->where('area',$request->area);
            }
        });
        $list = $listQuery->where('expiration_time','>=',Carbon::now())->get();

        return view('wharf.reverse-bidding.browse', compact('list', 'isCommunityLeader', 'areas'));


    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myBids()
    {

        $spotMarketBidsActiveQuery = ReverseBiddingBid::query();
        $spotMarketBidsActiveQuery = $spotMarketBidsActiveQuery->Where('user_id', auth()->user()->id);
        $spotMarketBidsActive = $spotMarketBidsActiveQuery->pluck('reverse_bidding_id')->toArray();

        $activeBids = ReverseBidding::whereIn('id', $spotMarketBidsActive)
            ->where('expiration_time', '>',now())
            ->get();

        $spotMarketBidsWinsQuery = ReverseBiddingBid::query();
        $spotMarketBidsWinsQuery = $spotMarketBidsWinsQuery->Where('user_id', auth()->user()->id);
        $spotMarketBidsWinsQuery = $spotMarketBidsWinsQuery->Where('winner', 1);
        $spotMarketBidsWins = $spotMarketBidsWinsQuery->pluck('reverse_bidding_id')->toArray();

        $winningBids = ReverseBidding::whereIn('id', $spotMarketBidsWins)
            ->where('expiration_time', '<',now())
            ->get();

        $spotMarketBidsLoseQuery = ReverseBiddingBid::query();
        $spotMarketBidsLoseQuery = $spotMarketBidsLoseQuery->Where('user_id', auth()->user()->id);
        $spotMarketBidsLoseQuery = $spotMarketBidsLoseQuery->Where('winner', 0);
        $spotMarketBidsLose = $spotMarketBidsLoseQuery->pluck('reverse_bidding_id')->toArray();
        $losingBids = ReverseBidding::whereIn('id', $spotMarketBidsLose)
            ->where('expiration_time', '<',now())
            ->whereNotIn('id', $winningBids)
            ->get();

        return view('wharf.reverse-bidding.my_bids', compact('activeBids', 'winningBids', 'losingBids'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $defaultAreaQuery = ReverseBidding::where('user_id', auth()->user()->id)->whereNotNull('area')->first();
        $defaultArea = "";
        if($defaultAreaQuery){
            $defaultArea = $defaultAreaQuery->area;
        }

        return view('wharf.reverse-bidding.create',compact('defaultArea'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postBid(Request $request)
    {
        $model = ReverseBidding::find($request->id);
        $current_bid = $model->current_bid;
        $bids = $model->bids;
        $value = floatval(preg_replace('/,/','',$request->value));

        if(count($bids) > 0){
            $current_bid = $bids->first()->bid;
            $current_bid+=settings('spot_market_next_bid');
        }

        if($current_bid > $value){
            return response()->json(['status' => false,'$current_bid'=>$current_bid,'value'=>$value]);
        }

        $model = new ReverseBiddingBid();
        $model->reverse_bidding_id = $request->id;
        $model->user_id = $request->user()->id;
        $model->bid = $request->value;
        $model->save();

        $nextBid = $request->value + settings('spot_market_next_bid');

        $bids = ReverseBiddingBid::where('reverse_bidding_id', $request->id)->orderBy('bid','desc')->pluck('bid')->toArray();

        event(new \App\Events\UpdateBidBrowse('reverse-bidding',$request->id));

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

        $model = ReverseBidding::find($request->id);
        $current_bid = $model->current_bid;

        $value = floatval(preg_replace('/,/','',$current_bid));

        $nextBid = $value + settings('spot_market_next_bid');

        $bids = ReverseBiddingBid::where('reverse_bidding_id', $request->id)->orderBy('bid','desc')->pluck('bid');

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
        ]);
        $array = $request->except('_token');
        $array['user_id'] = auth()->user()->id;
        $array["asking_price"] = preg_replace('/,/','', $array['selling_price']);
        $model = ReverseBidding::create($array);
        $expiration = Carbon::parse($model['created_at']);
        if($model['duration']){
            $duration = explode(':',$model['duration']);
            $expiration->addDays($request->days);
            $expiration->hours($duration[0]);
            $expiration->minute($duration[1]);
            $expiration->second(0);
        }
        $model->expiration_time = $expiration;
        $model->save();
        $model->addMedia($request->file('image'))
            ->toMediaCollection('reverse-bidding');

        return redirect()->route('reverse-bidding.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = ReverseBidding::find($id);
        return view('wharf.reverse-bidding.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Loan $loan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ReverseBidding::find($id);

        return view('wharf.reverse-bidding.edit', compact('data'));
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

        $data = ReverseBidding::find($id);
        $request->merge([
            'asking_price' => preg_replace('/,/','',$request->selling_price)
        ]);

        $data->update($request->except(['_token', 'image']));

        $expiration = Carbon::parse($data['created_at']);
        if($data['duration']){
            $duration = explode(':',$data['duration']);
            $expiration->addHour($duration[0]);
            $expiration->addMinute($duration[1]);
        }
        $data->expiration_time = $expiration;
        $data->save();
        if($request->hasFile('image')){
            $media = $data->getFirstMedia('reverse-bidding');
            if($media){
                $media->delete();
            }
            $data->addMedia($request->file('image'))->toMediaCollection('reverse-bidding');
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
            $spotMarketOrder->spot_market_id = $row['id'];
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
                ->toMediaCollection('spot-market-proof-payment');

            $this->spotMarketOrderService->verified($orders);

        }
        return redirect()->back()->with('success','Payment Verified!');
    }

}
