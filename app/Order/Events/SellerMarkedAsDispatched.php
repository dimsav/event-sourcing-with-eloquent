<?php

namespace App\Order\Events;

class SellerMarkedAsDispatched extends OrderEvent
{
    static public function getName()
    {
        return 'seller_market_as_dispatched';
    }
}
