<?php

namespace App\Jobs;

use App\Models\MvOrder;
use App\Order\Order;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateMvOrder
{
    use Dispatchable;

    private $orderId;

    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    public function handle()
    {
        if (!$mvOrder = MvOrder::find($this->orderId)) {
            $mvOrder = new MvOrder();
            $mvOrder->id = $this->orderId;
        }

        $order = Order::load($this->orderId);

        $mvOrder->total = $order->getTotal();
        $mvOrder->buyer_id = $order->getBuyerId();
        $mvOrder->seller_id = $order->getSellerId();
        $mvOrder->is_dispatched = (bool) $order->getDispatchedAt();
        $mvOrder->created_at = $order->getCreatedAt();
        $mvOrder->updated_at = $order->getUpdatedAt();
        $mvOrder->save();
    }
}
