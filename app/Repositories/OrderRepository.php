<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Services\ProductService;

class OrderRepository implements OrderRepositoryInterface
{
    protected $entity;
    private $productService;

    public function __construct(Order $order, ProductService $productService)
    {
        $this->entity = $order;
        $this->productService = $productService;
    }

    public function createNewOrder(
        string $identify,
        float $total,
        string $status,
        int $tenantId,
        string $comment = '',
        $clientId = '',
        $tableId = '',
        string $jsonData = '',
        string $integration = ''
    ) {
        $data = [
            'tenant_id' => $tenantId,
            'identify' => $identify,
            'total' => $total,
            'status' => $status,
            'comment' => $comment,
            'data' => $jsonData,
            'integration' => $integration
        ];

        if ($clientId) $data['client_id'] = $clientId;
        if ($tableId) $data['table_id'] = $tableId;

        $order = $this->entity->create($data);

        return $order;
    }


    public function getOrderByIdentify(string $identify)
    {
        return $this->entity
            ->where('identify', $identify)
            ->first();
    }

    public function registerProductsOrder(int $orderId, array $products)
    {
        $order = $this->entity->find($orderId);

        $orderProducts = [];

        foreach ($products as $product) {
            $orderProducts[$product['id']] = [
                'qty' => $product['qty'],
                'price' => $product['price'],
            ];

            if ($product['stock_controll'] == 1) {
                $this->productService->productStockOut($product['uuid'], $product['qty']);
            }
        }

        $order->products()->attach($orderProducts);
    }

    public function getOrdersByClientId(int $idClient)
    {
        $orders = $this->entity
            ->where('client_id', $idClient)
            ->orderBy('id', 'desc')
            ->paginate();

        return $orders;
    }

    public function ordersByClientByTenant(int $idClient, int $tenantId){
        $orders = $this->entity
        ->where([
            'client_id' => $idClient,
            'tenant_id' => $tenantId
            ])
        ->paginate();

    return $orders;
    }

    public function getOrdersByTenantId(int $idTenant, string $status, string $date = null)
    {
        $orders = $this->entity
            ->where('tenant_id', $idTenant)
            ->where(function ($query) use ($status) {
                if ($status != 'all') {
                    return $query->where('status', $status);
                }
            })
            ->where(function ($query) use ($date) {
                if ($date) {
                    return $query->whereDate('created_at', $date);
                }
            })
            ->get();

        return $orders;
    }

    public function updateStatusOrder(string $identify, string $status)
    {
        $this->entity->where('identify', $identify)->update(['status' => $status]);

        return $this->entity->where('identify', $identify)->first();
    }
}
