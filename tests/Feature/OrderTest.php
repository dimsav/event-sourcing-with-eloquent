<?php

namespace Tests\Feature;

use App\Models\MvOrder;
use App\Order\Order;
use Carbon\Carbon;
use Tests\TestCase;

class OrderTest extends TestCase
{
    public function testPlaceOrder()
    {
        $buyerId = $this->newUserId();
        $sellerId = $this->newUserId();
        $amount = 1000;
        $address = $this->faker()->name."\n".$this->faker()->address;

        $order = Order::create($buyerId, $sellerId, $amount, $address);

        $this->assertSame($buyerId, $order->getBuyerId());
        $this->assertSame($sellerId, $order->getSellerId());
        $this->assertSame($amount, $order->getTotal());
        $this->assertSame($address, $order->getAddress());
        $this->assertNotNull($orderId = $order->getId());

        $order = Order::load($order->getId());

        $this->assertSame($buyerId, $order->getBuyerId());
        $this->assertSame($sellerId, $order->getSellerId());
        $this->assertSame($amount, $order->getTotal());
        $this->assertSame($address, $order->getAddress());
        $this->assertSame($orderId, $order->getId());
    }

    public function testLoadOrderByWrongId()
    {
        $order = Order::load('abc');
        $this->assertNull($order);
    }

    public function testMarkOrderAsDispatched()
    {
        $buyerId = $this->newUserId();
        $sellerId = $this->newUserId();
        $amount = 1000;
        $address = $this->faker()->name."\n".$this->faker()->address;

        $order = Order::create($buyerId, $sellerId, $amount, $address);
        $order->sellerMarkedAsDispatched();
        $this->assertInstanceOf(Carbon::class, $order->getDispatchedAt());

        $order = Order::load($order->getId());
        $this->assertInstanceOf(Carbon::class, $order->getDispatchedAt());
    }

    public function testListDispatchedOrders()
    {
        $sellerId = $this->newUserId();
        $this->makeOrder($sellerId);
        $this->makeOrder($sellerId)->sellerMarkedAsDispatched();
        $this->makeOrder($sellerId)->sellerMarkedAsDispatched();

        $orders = MvOrder::where('is_dispatched', true)
                         ->where('seller_id', $sellerId)
                         ->get();
        $this->assertCount(2, $orders);
    }

    private function makeOrder($sellerId = null)
    {
        $buyerId = $this->newUserId();
        if (!$sellerId) {
            $sellerId = $this->newUserId();
        }
        $amount = 1000;
        $address = $this->faker()->name."\n".$this->faker()->address;

        return Order::create($buyerId, $sellerId, $amount, $address);
    }
}
