<?php

namespace App\Services;

class NotifyService
{
    protected $whatssappNewOrderNotifyService;
    protected $orderService;

    public function __construct(
        OrderService $orderService,
        WhatssappNewOrderNotifyService $whatssappNewOrderNotifyService
    ) {
        $this->orderService = $orderService;
        $this->whatssappNewOrderNotifyService = $whatssappNewOrderNotifyService;
    }

    public function notifyNewOrder(object $order)
    {
        $this->whatssappNewOrderNotifyService->newOrderNotify($order);        
    }
}
