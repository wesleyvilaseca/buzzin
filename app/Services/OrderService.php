<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderShipping;
use App\Models\Shipping;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\TableRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderService
{
    protected $orderRepository, $tenantRepository, $tableRepository, $productRepository;
    protected $whatssappNewOrderNotifyService;
    protected $tenantService;
    protected $zoneDeliveryService;
    private $tenant;
    protected $pdfFileService;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        TenantRepositoryInterface $tenantRepository,
        TableRepositoryInterface $tableRepository,
        ProductRepositoryInterface $productRepository,
        WhatssappNewOrderNotifyService $whatssappNewOrderNotifyService,
        TenantService $tenantService,
        ZoneShippingDeliveryService $zoneDeliveryService,
        PdfFileService $pdfFileService

    ) {
        $this->orderRepository = $orderRepository;
        $this->tenantRepository = $tenantRepository;
        $this->tableRepository = $tableRepository;
        $this->productRepository = $productRepository;
        $this->whatssappNewOrderNotifyService = $whatssappNewOrderNotifyService;
        $this->tenantService = $tenantService;
        $this->zoneDeliveryService = $zoneDeliveryService;
        $this->pdfFileService = $pdfFileService;
    }

    public function ordersByClient()
    {
        $idClient = $this->getClientIdByOrder();

        return $this->orderRepository->getOrdersByClientId($idClient);
    }

    public function ordersByClientByTenant(int $tenantId)
    {
        $idClient = $this->getClientIdByOrder();
        return $this->orderRepository->ordersByClientByTenant($idClient, $tenantId);
    }

    public function getOrderByIdentify(string $identify)
    {
        return $this->orderRepository->getOrderByIdentify($identify);
    }

    public function createNewOrder(array $order)
    {
        try {
            $this->tenant = $this->getTenantByOrder($order['token_company']);
            $paymentMethod = $order['paymentMethod'];
            $paymentMethod['data'] = decript($paymentMethod['data']);

            $productsOrder = $this->getProductsByOrder($order['products'] ?? []);
            $identify = $this->getIdentifyOrder();
            $order['cartPrice'] = $this->getTotalOrder($productsOrder);

            $shippingMethod = $this->getShippingMethod($order);

            $total = $order['cartPrice'] + tofloat($shippingMethod->price);

            if ($paymentMethod['tag'] == "pagar-em-dinheiro") {
                if ($order['precisaTroco'] == 'Y') {
                    $jsonData['precisa_de_troco'] = "Sim";
                    $jsonData['troco_para'] = tofloat($order['troco']);
                    $jsonData['valor_do_troco'] = tofloat($order['troco']) - $total;
                }

                if ($order['precisaTroco'] == 'N') {
                    $jsonData['precisa_de_troco'] = "Sim";
                }
            }

            $status = 'open';
            $tenantId = $this->tenant->id;
            $comment = isset($order['comment']) ? $order['comment'] : '';
            $clientId = $this->getClientIdByOrder();
            $tableId = $this->getTableIdByOrder($order['table'] ?? '');

            $jsonData['client_address'] = $order['address'];
            $jsonData['payment_method'] = $paymentMethod;
            $jsonData['shipping_method'] = $shippingMethod;

            $order = $this->orderRepository->createNewOrder(
                $identify,
                $total,
                $status,
                $tenantId,
                $comment,
                $clientId,
                $tableId,
                json_encode($jsonData),
            );
            $this->orderRepository->registerProductsOrder($order->id, $productsOrder);

            $pdfFileDetailsOrder = $this->pdfFileService->makePdfOrderDetail($order);
            if ($pdfFileDetailsOrder) {
                Order::where('id', $order->id)
                    ->update([
                        'data' => DB::raw("JSON_INSERT(data, '$.pdfFileDetailsOrder', '$pdfFileDetailsOrder')")
                    ]);
            }
            $order = $this->getOrderByIdentify($order->identify);
            
            return $order;
        } catch (Exception $e) {
            return  $e->getMessage();
        }
    }

    private function getShippingMethod(array $order)
    {
        $tenant = $this->tenant;
        $selectedShippingMethod = $order['shippingMethod'];

        $data = [];
        $data['cep'] = str_replace("-", "", $order['address']['zip_code']);
        $data['cartPrice'] = $order['cartPrice'];

        $tenantShipping = $tenant->tenantShipping()->where([
            'status' => 1,
            'alias' => $selectedShippingMethod['alias']
        ])->first();

        if (!$tenantShipping) {
            throw new Error('Metodo de entrega não localizado');
        }

        switch ($selectedShippingMethod['alias']) {
            case Shipping::ALIAS_MAKE_DELIVERY:
                try {
                    return $this->zoneDeliveryService->getShippingDeliveryDetailByCep($data, $tenantShipping);
                } catch (Exception $e) {
                    return  $e->getMessage();
                }
                break;

            case Shipping::ALIAS_GET_ON_STORE:
                return   (object) [
                    'description' => $tenantShipping->shipping()->first()->description,
                    'price' => numberFormat(0.00),
                    'alias' => $tenantShipping->shipping()->first()->alias
                ];
            default:
                throw new Error('Metodo de entrega não existente');
        }
    }

    private function getIdentifyOrder(int $qtyCaraceters = 8)
    {
        $smallLetters = str_shuffle('abcdefghijklmnopqrstuvwxyz');

        $numbers = (((date('Ymd') / 12) * 24) + mt_rand(800, 9999));
        $numbers .= 1234567890;

        // $specialCharacters = str_shuffle('!@#$%*-');

        // $characters = $smallLetters.$numbers.$specialCharacters;
        $characters = $smallLetters . $numbers;

        $identify = substr(str_shuffle($characters), 0, $qtyCaraceters);

        if ($this->orderRepository->getOrderByIdentify($identify)) {
            $this->getIdentifyOrder($qtyCaraceters + 1);
        }

        return $identify;
    }

    private function getProductsByOrder(array $productsOrder): array
    {
        $products = [];
        foreach ($productsOrder as $productOrder) {
            $product = $this->productRepository->getProductByUuid($productOrder['identify']);
            array_push($products, [
                'id' => $product->id,
                'uuid' => $product->uuid,
                'qty' => $productOrder['qty'],
                'stock_controll' => $product->stock_controll,
                'price' => $product->price,
            ]);
        }

        return $products;
    }

    private function getTotalOrder(array $products): float
    {
        $total = 0;

        foreach ($products as $product) {
            $total += ($product['price'] * $product['qty']);
        }

        return tofloat($total);
    }

    private function getTenantByOrder(string $uuid): object
    {
        return $this->tenantRepository->getTenantByUuid($uuid);
    }

    private function getTableIdByOrder(string $uuid = '')
    {
        if ($uuid) {
            $table = $this->tableRepository->getTableByUuid($uuid);

            return $table->id;
        }

        return '';
    }

    private function getClientIdByOrder()
    {
        return auth()->check() ? auth()->user()->id : '';
    }

    public function getOrdersByTenantId(int $idTenant, string $status, string $date = null)
    {
        return $this->orderRepository->getOrdersByTenantId($idTenant, $status, $date);
    }

    public function updateStatusOrder(string $identify, string $status)
    {
        return $this->orderRepository->updateStatusOrder($identify, $status);
    }
}
