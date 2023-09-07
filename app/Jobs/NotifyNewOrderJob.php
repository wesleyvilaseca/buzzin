<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\OrderService;
use App\Services\PdfFileService;
use App\Services\WhatssappNewOrderNotifyService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class NotifyNewOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $order;
    protected $pdfFileService;
    protected $whatssappNewOrderNotifyService;
    protected $orderService;
    public $timeout = 300;  
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(object $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $pdfFileService = app(PdfFileService::class);
        $whatssappNewOrderNotifyService = app(WhatssappNewOrderNotifyService::class);
        $orderService = app(OrderService::class);

        $pdfFileDetailsOrder = $pdfFileService->makePdfOrderDetail($this->order);
        if ($pdfFileDetailsOrder) {
            Order::where('id', $this->order->id)
                ->update([
                    'data' => DB::raw("JSON_INSERT(data, '$.pdfFileDetailsOrder', '$pdfFileDetailsOrder')")
                ]);
        }
        $this->order = $orderService->getOrderByIdentify($this->order->identify);
        $whatssappNewOrderNotifyService->newOrderNotify($this->order);
    }
}
