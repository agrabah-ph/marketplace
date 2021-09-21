<?php

namespace App\Services;

use App\MarketplaceOrder;
use App\SpotMarketOrder;
use App\MarketplaceOrderStatus;

class MarketplaceOrderService
{
    public function newOrder(MarketplaceOrder $order)
    {
        $orderStatus = new MarketplaceOrderStatus();
        $orderStatus->market_place_order_id = $order->id;
        $orderStatus->status = 'new';
        $orderStatus->is_current = 1;
        $orderStatus->save();
    }

    public function verified(MarketplaceOrder $order)
    {
        $orderStatus = MarketplaceOrderStatus::where('market_place_order_id', $order->id)->first();
        if($orderStatus){
            $this->setZeroOld($order->id);

            $orderStatus = new MarketplaceOrderStatus();
            $orderStatus->market_place_order_id = $order->id;
            $orderStatus->status = 'payment_verified';
            $orderStatus->is_current = 1;
            $orderStatus->save();
        }
    }

    public function approved(MarketplaceOrder $order)
    {
        $orderStatus = MarketplaceOrderStatus::where('market_place_order_id', $order->id)->first();
        if($orderStatus){
            $this->setZeroOld($order->id);

            $orderStatus = new MarketplaceOrderStatus();
            $orderStatus->market_place_order_id = $order->id;
            $orderStatus->status = 'approved';
            $orderStatus->is_current = 1;
            $orderStatus->save();
        }
    }

    public function delivery(MarketplaceOrder $order)
    {
        $orderStatus = MarketplaceOrderStatus::where('market_place_order_id', $order->id)->first();
        if($orderStatus){
            $this->setZeroOld($order->id);

            $orderStatus = new MarketplaceOrderStatus();
            $orderStatus->market_place_order_id = $order->id;
            $orderStatus->status = 'delivery';
            $orderStatus->is_current = 1;
            $orderStatus->save();
        }
    }
    public function delivered(MarketplaceOrder $order)
    {
        $orderStatus = MarketplaceOrderStatus::where('market_place_order_id', $order->id)->first();
        if($orderStatus){
            $this->setZeroOld($order->id);

            $orderStatus = new MarketplaceOrderStatus();
            $orderStatus->market_place_order_id = $order->id;
            $orderStatus->status = 'delivered';
            $orderStatus->is_current = 1;
            $orderStatus->save();
        }
    }

    public function setZeroOld($orderNumber)
    {
        MarketplaceOrderStatus::where('market_place_order_id', $orderNumber)->update(['is_current' => 0]);
    }
}
