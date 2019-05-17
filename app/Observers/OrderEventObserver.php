<?php

namespace App\Observers;

use App\Jobs\UpdateMvOrder;
use App\Models\OrderEventModel;
use App\Order\Events\SellerMarkedAsDispatched;

class OrderEventObserver
{
    public function created(OrderEventModel $orderEventModel)
    {
        UpdateMvOrder::dispatch($orderEventModel->order_id);

        if ($orderEventModel->name == SellerMarkedAsDispatched::getName()) {
            // Send email to buyer: your order has been dispatched.
        }
    }
}
