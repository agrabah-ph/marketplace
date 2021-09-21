<?php

namespace App\Http\Controllers;


use App\MarketPlace;
use App\MarketplaceCart;
use App\MarketplaceOrder;
use App\MarketplaceOrderItem;
use App\MarketplaceOrderPayment;
use App\Services\MarketplaceInventoryService;
use App\Services\MarketplaceOrderService;
use App\SpotMarket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarketPlaceCartingController extends Controller
{
    /**
     * @var MarketplaceOrderService
     */
    private $marketplaceOrderService;
    /**
     * @var MarketplaceInventoryService
     */
    private $marketplaceInventoryService;

    public function __construct(
        MarketplaceOrderService $marketplaceOrderService,
        MarketplaceInventoryService $marketplaceInventoryService
    )
    {
        $this->marketplaceOrderService = $marketplaceOrderService;
        $this->marketplaceInventoryService = $marketplaceInventoryService;

    }
    public function index()
    {
        $marketList = MarketPlace::all();

        return view('wharf.market-place.listing', compact('marketList'));

    }

    public function cart()
    {
        $cart = MarketPlace::
        join('marketplace_carts', 'marketplace_carts.market_place_id','=','market_places.id')
            ->where('user_id', auth()->user()->id)
            ->select(
                'market_places.*',
                'marketplace_carts.id as cart_id',
                'marketplace_carts.quantity as cart_quantity'
            )
            ->get();
        return view('wharf.market-place.cart', compact('cart'));
    }


    public function myOrders()
    {
        $orders = MarketPlaceOrder::with('items.product')
            ->orderBy('created_at','desc')
            ->get();
        return view('wharf.market-place.my_orders', compact('orders'));
    }


    public function inventoryActions(Request  $request)
    {
        $marketplace = Marketplace::find($request->id);
        $quantity = $request->int_qty;
        $remark = 'Remove';
        if(floatval($quantity) != 0){
            if(floatval($quantity) > 0){
                $remark = 'Add';
            }
            $this->marketplaceInventoryService->save($marketplace, $request->int_qty,$remark);
        }
        return redirect()->back()->with('success','Successfully saved inventory!');
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
        return view('wharf.market-place.show-product', compact('data'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addToCart(Request $request)
    {

        $array = [
            'user_id' => auth()->user()->id,
            'market_place_id' => $request->id
        ];
        $cart = MarketplaceCart::firstOrNew($array);
        $cart->quantity = $cart->quantity + 1;
        $cart->save();
        return getUserMarketplaceCartCount();

    }

    public function orders()
    {
        $orders = MarketplaceOrder::with('user','payment','items.product')
            ->orderBy('created_at','desc')
            ->get();

        return view('wharf.market-place.orders', compact( 'orders'));

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function removeItem(Request $request)
    {

        $array = [
            'user_id' => auth()->user()->id,
            'id' => $request->id
        ];
        $cart = MarketplaceCart::where($array);
        $cart->delete();
        return 1;

    }


    public function lockInOrder(Request $request)
    {

        $formStringify = $request->input('form');
        $form = json_decode($formStringify,true);
        DB::beginTransaction();
        $orderNumber = sprintf('%08d', MarketplaceOrder::count()+1);

        $order = new MarketplaceOrder();
        $order->order_number = $orderNumber;
        $order->user_id = auth()->user()->id;
        $order->quantity = 0;
        $order->total = 0;
        $order->sub_total = 0;
        $order->service_fee = 0;
        $quantity = 0;
        $total = 0;
        if($order->save()){

            foreach($form as $row){

                $orderItem = new MarketplaceOrderItem();
                $orderItem->market_place_order_id = $order->id;
                $orderItem->market_place_id = $row['id'];
                $orderItem->price = $row['price'];
                $orderItem->quantity = $row['qty'];
                $orderItem->total = $row['sub_total'];
                $orderItem->save();

                $quantity += $orderItem->quantity;
                $total += $orderItem->total;

                $cart = MarketplaceCart::find($row['cart_id']);
                if($cart){
                    $cart->delete();
                }else{
                }
            }

            $this->marketplaceOrderService->newOrder($order);
            $this->marketplaceInventoryService->save($orderItem->product, '-'.$orderItem->quantity, 'Sell');
            $order->quantity = $quantity;
            $order->total = $total;
            $order->sub_total = $total;
            $order->save();
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
        $orders = MarketplaceOrder::find($request->order_number);
        if($orders){
            $payment = new MarketplaceOrderPayment();
            $payment->market_place_order_id = $request->order_number;
            $payment->payment_date = $request->paid_date;
            $payment->reference_number = $request->reference_number;
            $payment->save();
            $payment->addMedia($request->file('proof_of_payment'))
                ->toMediaCollection('market-place-proof-payment');

            $this->marketplaceOrderService->verified($orders);
            return redirect()->back()->with('success','Payment Verified!');


        }
        return redirect()->back()->with('danger','Order not found!');

    }

    public function deliver(Request  $request)
    {
        $marketplaces = MarketplaceOrder::find($request->id);

        $this->marketplaceOrderService->delivery($marketplaces);

        return redirect()->back()->with('success','Successfully change status to delivery!');

    }

    public function delivered(Request  $request)
    {
        $marketplaces = MarketplaceOrder::find($request->id);

        $this->marketplaceOrderService->delivered($marketplaces);

        return redirect()->back()->with('success','Successfully change status to delivered! Thank you!');

    }

}