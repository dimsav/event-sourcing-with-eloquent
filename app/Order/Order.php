<?php

namespace App\Order;

use App\Models\OrderEventModel;
use App\Order\Events\OrderEvent;
use App\Order\Events\OrderWasPlaced;
use App\Order\Events\SellerMarkedAsDispatched;

class Order
{
    private $id;
    private $buyerId;
    private $sellerId;
    private $total;
    private $address;
    private $createdAt;
    private $updatedAt;
    private $dispatchedAt;

    private static $eventClasses = [
        OrderWasPlaced::class,
        SellerMarkedAsDispatched::class,
    ];

    public static function create($buyerId, $sellerId, $total, $address)
    {
        $order = new Order;
        $order->id = uuid();
        $event = OrderWasPlaced::make($buyerId, $sellerId, $total, $address);
        $order->storeAndApplyEvent($event);
        return $order;
    }

    public static function load($id)
    {
        $events = OrderEventModel::where('order_id', $id)->orderBy('id', 'asc')->get();
        if ($events->count() == 0) {
            return null;
        }
        $order = new Order;
        foreach ($events as $event) {
            $order->applyModelEvent($event);
        }

        return $order;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getBuyerId()
    {
        return $this->buyerId;
    }

    public function getSellerId()
    {
        return $this->sellerId;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getDispatchedAt()
    {
        return $this->dispatchedAt;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function sellerMarkedAsDispatched()
    {
        $event = new SellerMarkedAsDispatched;
        $this->storeAndApplyEvent($event);
    }

    protected function storeAndApplyEvent(OrderEvent $event)
    {
        $this->storeEvent($event);
        $this->applyEvent($event);
    }

    protected function storeEvent(OrderEvent $event)
    {
        $eventModel = OrderEventModel::create([
            'order_id' => $this->id,
            'name' => $event->getName(),
            'data' => $event->getData(),
            'created_at' => now(),
        ]);
        $this->fillEventFromModel($event, $eventModel);
    }

    protected function applyEvent(OrderEvent $event)
    {
        if ($event instanceof OrderWasPlaced) {
            $this->id = $event->getOrderId();
            $this->total = $event->getTotal();
            $this->buyerId = $event->getBuyerId();
            $this->sellerId = $event->getSellerId();
            $this->address = $event->getAddress();
            $this->createdAt = $event->getTimestamp();
        } elseif ($event instanceof SellerMarkedAsDispatched) {
            $this->dispatchedAt = $event->getTimestamp();
        }

        $this->updatedAt = $event->getTimestamp();
    }

    private function fillEventFromModel(OrderEvent $event, OrderEventModel $eventModel)
    {
        $event->setTimestamp($eventModel->created_at);
        $event->setOrderId($eventModel->order_id);
        $event->setId($eventModel->id);
    }

    private function loadEventByModel(OrderEventModel $eventModel)
    {
        $eventClass = static::getEventClassByName($eventModel->name);
        /** @var OrderEvent $event */
        $event = new $eventClass;
        $event->setData($eventModel->data);
        $this->fillEventFromModel($event, $eventModel);

        return $event;
    }

    private function applyModelEvent(OrderEventModel $eventModel)
    {
        $event = $this->loadEventByModel($eventModel);
        $this->applyEvent($event);
    }

    protected static function getEventClassByName($name)
    {
        foreach (static::$eventClasses as $eventClass) {
            if ($eventClass::getName() == $name) {
                return $eventClass;
            }
        }
        return null;
    }
}
