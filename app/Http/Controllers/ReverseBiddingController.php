<?php

namespace App\Http\Controllers;

use App\BfarNotifications;
use App\Farmer;
use App\Http\Resources\SpotMarketBrowseCollection;
use App\Loan;
use App\MarketplaceCategories;
use App\ReverseBidding;
use App\ReverseBiddingBid;
use App\ReverseBiddingItems;
use App\ReverseBiddingOffers;
use App\Rules\PurchaseOrderSubmitOffer;
use App\Services\LoanService;
use App\Services\NotificationService;
use App\Services\SpotMarketOrderService;
use App\SpotMarket;
use App\SpotMarketBid;
use App\SpotMarketCart;
use App\SpotMarketOrder;
use App\SpotMarketPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ReverseBiddingController extends Controller
{
    /**
     * @var NotificationService
     */
    private $notificationService;

    /**
     * @var NotificationService
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
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
        if($roleName == 'enterprise-client'){
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
        $list = $listQuery
//            ->where('expiration_time','>=',Carbon::now())
            ->orderBy('expiration_time', 'desc')
            ->get();


        return view('wharf.reverse-bidding.browse', compact('list', 'isCommunityLeader', 'areas'));


    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function completeBid(Request $request)
    {
        DB::beginTransaction();
        $spotMarket = ReverseBidding::find($request->id);
        $method = $request->input('method');
        $spotMarket->method = $method;
        $spotMarket->status = 1;
        $spotMarket->save();

        if($method == 'transport'){

            foreach($spotMarket->items as $item){
                $product_name = $item->item_name;
                $quantity = $item->quantity;
                $bfar_notifcation = BfarNotifications::create([
                    'from' => $request->from,
                    'product' => $product_name,
                    'quantity' => $quantity,
                    'unit_of_measure' => $request->unit_of_measure,
                    'destination' => $request->destination,
                    'com_leader_user_id' => auth()->user()->id,
                    'date_of_travel' => $request->date_of_travel,
                    'type_of_vehicle' => $request->type_of_vehicle
                ]);
                $this->notificationService->notifyBFAR($spotMarket->name, $spotMarket->area, $spotMarket->current_bid);
            }

        }

        DB::commit();
        if($request->ajax()){
            return response()->json(['status'=>true]);
        }


        return redirect()->back();
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
        $categories = MarketplaceCategories::orderBy('name')->get();

        return view('wharf.reverse-bidding.create',compact('defaultArea', 'categories'));
    }

    public function submitOfferBid(Request $request)
    {

        $array = $request->except('_token');
        DB::beginTransaction();


        $validate = Validator::make($array, [
            'item_price' => [
                'required',
                new PurchaseOrderSubmitOffer()
            ],
            'total_bid' => 'required',
            'vat' => 'required',
            'transaction_fee' => 'required',
            'gross_total' => 'required',
            'agree' => 'required',
        ])->validate();

        $json_bids = [];
        foreach($array['item_price'] as $key => $price){
            $json_bids[] = [
                'id' =>$array['item_id'][$key],
                'price' =>$price,
                'cost' =>$array['item_cost'][$key],
            ];
        }

        $offer = ReverseBiddingOffers::create([
            'reverse_bidding_id' => $array['po_id'],
            'user_id' => auth()->user()->id,
            'gross_total' => $array['gross_total'],
            'service_fee' => $array['gross_total'],
            'vat' => $array['vat'],
            'total_bid' => $array['total_bid'],
            'bids' => json_encode($json_bids, true),
            'agree_on' => now()->toDateTimeString(),
        ]);
//        return $offer;
//
        event(new \App\Events\UpdateBidBrowse('reverse-bidding',$array['po_id']));
        DB::commit();

        return redirect()->back()->with('success', 'Successfully Submitted Offer!');
//        dd($request->all());
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
            $current_bid-=settings('spot_market_next_bid');
        }

        if($current_bid < $value){
            return response()->json(['status' => false,'$current_bid'=>$current_bid,'value'=>$value]);
        }

        $model = new ReverseBiddingBid();
        $model->reverse_bidding_id = $request->id;
        $model->user_id = $request->user()->id;
        $model->bid = $request->value;
        $model->save();

        $nextBid = $request->value + settings('spot_market_next_bid');

        $bids = ReverseBiddingBid::where('reverse_bidding_id', $request->id)->orderBy('bid','asc')->pluck('bid')->toArray();

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
        $data = ReverseBidding::find($request->id);
        $offers = $data->offers;
//        $offers = ReverseBiddingOffers::where('reverse_bidding_id', $request->id)->orderBy('total_bid')->get();
        $items = ReverseBiddingItems::where('reverse_bidding_id', $request->id)->pluck('item_name', 'id')->toArray();
        $qtys = ReverseBiddingItems::where('reverse_bidding_id', $request->id)->pluck('quantity', 'id')->toArray();
        $rank = $data->user_rank;
        return response()->json([
            'view' => view('wharf.reverse-bidding.offers', compact('offers', 'items', 'qtys'))->render(),
            'rank' => $rank
        ]);

//  Old Code
//        $array = $request->all();
//
//        $model = ReverseBidding::find($request->id);
//        $current_bid = $model->current_bid;
//
//        $value = floatval(preg_replace('/,/','',$current_bid));
//
//        $nextBid = $value - settings('spot_market_next_bid');
//
//        $bids = ReverseBiddingBid::where('reverse_bidding_id', $request->id)->orderBy('bid','asc')->pluck('bid');
//
//        return response()->json(['status' => true, 'bids' => $bids, 'next_bid' => $nextBid, 'current_bid'=>$current_bid, 'value'=>$value]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $array = $request->except('_token');
        $array['user_id'] = auth()->user()->id;
        $array['delivery_date_time'] = Carbon::createFromFormat('m/d/Y H:i',$request->delivery_date. ' ' .$request->delivery_time);
        $array['delivery_date_time'] = $array['delivery_date_time']->toDateTimeString();
        $array['expiration_time'] = Carbon::createFromFormat('m/d/Y H:i',$request->bid_end_date. ' ' .$request->bid_end_time);
        $array['expiration_time'] = $array['expiration_time']->toDateTimeString();

        DB::beginTransaction();
        $array['category_id'] = $request->category;
        $model = ReverseBidding::create($array);
        $model->save();
        $model->addMedia($request->file('image'))
            ->toMediaCollection('reverse-bidding');

        $itemsNames = $request->item_name;
        $itemsQuantity = $request->item_quantity;
        $itemsUnitOfMeasure = $request->item_unit_of_measure;
        foreach($itemsNames as $key => $itemsName){
            $arrayItems = [];
            $arrayItems['reverse_bidding_id'] = $model->id;
            $arrayItems['item_name'] = $itemsName;
            $arrayItems['quantity'] = $itemsQuantity[$key];
            $arrayItems['unit_of_measure'] = $itemsUnitOfMeasure[$key];
            $modelItems = ReverseBiddingItems::create($arrayItems);
        }
        DB::commit();
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
        $items = ReverseBiddingItems::where('reverse_bidding_id', $id)->pluck('item_name', 'id')->toArray();
        $qtys = ReverseBiddingItems::where('reverse_bidding_id', $id)->pluck('quantity', 'id')->toArray();
        return view('wharf.reverse-bidding.show', compact('data', 'items', 'qtys'));
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

        $categories = MarketplaceCategories::orderBy('name')->get();

        return view('wharf.reverse-bidding.edit', compact('data', 'categories'));
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


        $array = $request->except('_token');
        $array['user_id'] = auth()->user()->id;
        $array['delivery_date_time'] = Carbon::createFromFormat('m/d/Y H:i',$request->delivery_date. ' ' .$request->delivery_time);
        $array['delivery_date_time'] = $array['delivery_date_time']->toDateTimeString();
        $array['expiration_time'] = Carbon::createFromFormat('m/d/Y H:i',$request->bid_end_date. ' ' .$request->bid_end_time);
        $array['expiration_time'] = $array['expiration_time']->toDateTimeString();

        DB::beginTransaction();
        $array['category_id'] = $request->category;
        $model = ReverseBidding::create($array);
        $model->save();
        $model->addMedia($request->file('image'))
            ->toMediaCollection('reverse-bidding');

        $itemsNames = $request->item_name;
        $itemsQuantity = $request->item_quantity;
        $itemsUnitOfMeasure = $request->item_unit_of_measure;
        foreach($itemsNames as $key => $itemsName){
            $arrayItems = [];
            $arrayItems['reverse_bidding_id'] = $model->id;
            $arrayItems['item_name'] = $itemsName;
            $arrayItems['quantity'] = $itemsQuantity[$key];
            $arrayItems['unit_of_measure'] = $itemsUnitOfMeasure[$key];
            $modelItems = ReverseBiddingItems::create($arrayItems);
        }
        DB::commit();
        return $request->all();

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
