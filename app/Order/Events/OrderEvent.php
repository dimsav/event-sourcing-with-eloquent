<?php

namespace App\Order\Events;

use Illuminate\Support\Arr;

abstract class OrderEvent
{
    protected $id;
    protected $data;
    protected $orderId;
    protected $timestamp;

    abstract static public function getName();

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    protected function getValue($key)
    {
        return Arr::get($this->data, $key);
    }
}
