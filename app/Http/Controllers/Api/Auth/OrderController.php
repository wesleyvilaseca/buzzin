<?php

namespace App\Http\Controllers\Api\Auth;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreOrder;
use App\Http\Resources\OrderClientResource;
use App\Http\Resources\OrderResource;
use App\Jobs\NotifyNewOrderJob;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(
        OrderService $orderService,
    ) {
        $this->orderService = $orderService;
    }


    public function store(StoreOrder $request)
    {
        DB::beginTransaction();
        try {
            $order = $this->orderService->createNewOrder($request->all());
            broadcast(new OrderCreated($order));
            dispatch(new NotifyNewOrderJob($order));
            DB::commit();
            return new OrderResource($order);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Houve um erro na requisição, tente novamento', 'detail' => $e->getMessage()], 404);
        }
    }

    public function show($identify)
    {
        if (!$order = $this->orderService->getOrderByIdentify($identify)) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        return new OrderResource($order);
    }

    public function myOrders()
    {
        $orders = $this->orderService->ordersByClient();
        return OrderClientResource::collection($orders);
    }
}
