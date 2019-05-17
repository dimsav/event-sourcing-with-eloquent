<?php

namespace App\Order\Events;

class OrderWasPlaced extends OrderEvent
{
    public static function make($buyerId, $sellerId, $total, $address)
    {
        return new static([
            'buyer_id' => $buyerId,
            'seller_id' => $sellerId,
            'total' => $total,
            'address' => $address,
        ]);
    }

    public function getTotal()
    {
        return $this->getValue('total');
    }

    public function getBuyerId()
    {
        return $this->getValue('buyer_id');
    }

    public function getSellerId()
    {
        return $this->getValue('seller_id');
    }

    public function getAddress()
    {
        return $this->getValue('address');
    }

    static public function getName()
    {
        return 'order_placed';
    }
}
