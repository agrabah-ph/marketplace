<?php

namespace App\Services;

use App\SpotMarketOrder;
use App\SpotMarketOrderStatus;

class SpotMarketOrderService
{
    public function newOrder(SpotMarketOrder $order)
    {
        $orderStatus = new SpotMarketOrderStatus();
        $orderStatus->spot_market_orders = $order->order_number;
        $orderStatus->status = 'new';
        $orderStatus->is_current = 1;
        $orderStatus->save();
    }

    public function verified(SpotMarketOrder $order)
    {
        $orderStatus = SpotMarketOrderStatus::where('spot_market_orders', $order->order_number)->first();
        if($orderStatus){
            $this->setZeroOld($order->order_number);

            $orderStatus = new SpotMarketOrderStatus();
            $orderStatus->spot_market_orders = $order->order_number;
            $orderStatus->status = 'payment_verified';
            $orderStatus->is_current = 1;
            $orderStatus->save();
        }
    }

    public function approved(SpotMarketOrder $order)
    {
        $orderStatus = SpotMarketOrderStatus::where('spot_market_orders', $order->order_number)->first();
        if($orderStatus){
            $this->setZeroOld($order->order_number);

            $orderStatus = new SpotMarketOrderStatus();
            $orderStatus->spot_market_orders = $order->order_number;
            $orderStatus->status = 'approved';
            $orderStatus->is_current = 1;
            $orderStatus->save();
        }
    }

    public function delivery(SpotMarketOrder $order)
    {
        $orderStatus = SpotMarketOrderStatus::where('spot_market_orders', $order->order_number)->first();
        if($orderStatus){
            $this->setZeroOld($order->order_number);

            $orderStatus = new SpotMarketOrderStatus();
            $orderStatus->spot_market_orders = $order->order_number;
            $orderStatus->status = 'delivery';
            $orderStatus->is_current = 1;
            $orderStatus->save();
        }
    }

    public function setZeroOld($orderNumber)
    {
        SpotMarketOrderStatus::where('spot_market_orders', $orderNumber)->update(['is_current' => 0]);
    }
}
