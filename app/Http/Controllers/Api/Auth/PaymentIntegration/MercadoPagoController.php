<?php

namespace App\Http\Controllers\Api\Auth\PaymentIntegration;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\PaymentIntegration\MercadoPagoOrderPaymentService;
use App\Services\OrderService;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class MercadoPagoController extends Controller
{
    private $tenant;
    private $client;
    private $orderService;
    private $mercadoPagoOrderPaymentService;

    public function __construct(OrderService $orderService, MercadoPagoOrderPaymentService $mercadoPagoOrderPaymentService)
    {
        $this->orderService = $orderService;
        $this->mercadoPagoOrderPaymentService = $mercadoPagoOrderPaymentService;
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->payment_integration_params) {
                if (!validaCPF($request->payment_integration_params['cpf'])) {
                    $errors['cpf'][] = 'O CPF informado é inválido';
                    return response()->json((object) ["errors" => $errors], 400);
                }
            }

            $res = $this->orderService->createNewOrder($request->all());
            $data = json_decode($res->data);
            $data->payment_integration_params = $request->payment_integration_params;
            $res = tap(DB::table('orders')->where('id', $res->id))->update(
                [
                    'data' => json_encode($data),
                    'integration' => $this->mercadoPagoOrderPaymentService::INTEGRATION
                ]
            )->first();
            
            $order = Order::find($res->id);
            $res = $this->mercadoPagoOrderPaymentService->startPayment($order);
            broadcast(new OrderCreated($order));
            
            return new OrderResource($order);
            DB::commit();
            return $res;
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Houve um erro na requisição, tente novamento', 'detail' => $e->getMessage()], 404);
        }
    }
}
