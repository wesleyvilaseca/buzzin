<?php

namespace App\Services;

use App\Models\OrderShipping;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\TableRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Exception;
use Illuminate\Support\Facades\DB;

use function Psy\debug;

class OrderService
{
    protected $orderRepository, $tenantRepository, $tableRepository, $productRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        TenantRepositoryInterface $tenantRepository,
        TableRepositoryInterface $tableRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->tenantRepository = $tenantRepository;
        $this->tableRepository = $tableRepository;
        $this->productRepository = $productRepository;
    }

    public function ordersByClient()
    {
        $idClient = $this->getClientIdByOrder();

        return $this->orderRepository->getOrdersByClientId($idClient);
    }

    public function getOrderByIdentify(string $identify)
    {
        return $this->orderRepository->getOrderByIdentify($identify);
    }

    public function createNewOrder(array $order)
    {
        DB::beginTransaction();
        try {
            $clientAdress = $order['address'];
            $paymentMethod = $order['paymentMethod'];
            $shippingMethod = $order['shippingMethod'];

            $jsonData = [
                'client_address' => $clientAdress,
                'payment_method' => $paymentMethod,
                'shipping_method' => $shippingMethod
            ];

            $productsOrder = $this->getProductsByOrder($order['products'] ?? []);
            $identify = $this->getIdentifyOrder();
            $total = $this->getTotalOrder($productsOrder) + tofloat($shippingMethod['price']);

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
            $tenantId = $this->getTenantIdByOrder($order['token_company']);
            $comment = isset($order['comment']) ? $order['comment'] : '';
            $clientId = $this->getClientIdByOrder();
            $tableId = $this->getTableIdByOrder($order['table'] ?? '');

            $order = $this->orderRepository->createNewOrder(
                $identify,
                $total,
                $status,
                $tenantId,
                $comment,
                $clientId,
                $tableId,
                json_encode($jsonData)
            );

            $this->orderRepository->registerProductsOrder($order->id, $productsOrder);

            DB::commit();
            return $order;
        } catch (Exception $e) {
            // dd($e->getMessage());
            return response()->json(['message' => 'Houve um erro na requisição, tente novamento'], 404);
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
                'qty' => $productOrder['qty'],
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

    private function getTenantIdByOrder(string $uuid)
    {
        $tenant = $this->tenantRepository->getTenantByUuid($uuid);

        return $tenant->id;
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
