<?php

namespace App\Order\Events;

class SellerUpdatedTotal extends OrderEvent
{
    static public function getName()
    {
        return 'seller_updated_total';
    }

    public static function make($amount)
    {
        return new static([
            'amount' => $amount,
        ]);
    }

    public function getTotal()
    {
        return $this->getValue('amount');
    }
}
