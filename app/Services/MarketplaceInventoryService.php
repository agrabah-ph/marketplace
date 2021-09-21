<?php

namespace App\Services;

use App\MarketPlace;
use App\MarketplaceInventory;
use App\MarketplaceOrder;
use App\SpotMarketOrder;
use App\MarketplaceOrderStatus;

class MarketplaceInventoryService
{
    public function save(MarketPlace $order, $qty, $remarks = null)
    {
        $orderStatus = new MarketplaceInventory();
        $orderStatus->user_id = auth()->user()->id;
        $orderStatus->market_place_id = $order->id;
        $orderStatus->quantity = $qty;
        $orderStatus->remarks = $remarks;
        $orderStatus->save();
    }

    public function totalQuantity(MarketPlace $order)
    {
        return MarketplaceInventory::where('marketplace_order_id', $order->id)->sum('quantity');
    }
}
