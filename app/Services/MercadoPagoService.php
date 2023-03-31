<?php

namespace App\Services;

use App\Models\Plan;
use App\Repositories\Contracts\TableRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

class MercadoPagoService
{
    protected $httpClient;
    private $access_token;

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->access_token = env('MP_PRODUCTION') ? env('MERCADO_PAGO_TOKEN') : env('MERCADO_PAGO_SANDBOX_TOKEN');
    }

    public function processPayment(array $data)
    {
        $plan = Plan::find($data['plan_id']);
        if (!$plan) {
            return response()->json(['message' => 'Operação não autorizada'], 401);
        }

        try {
            $tenant = Auth::user()->tenant;
            $apiUrl = 'https://api.mercadopago.com/v1/payments';

            $form = [
                'external_reference' => $tenant->uuid,
                'transaction_amount' => (float) $plan->price,
                'token' => $data['token'],
                'description' => $plan->name,
                'installments' => (int) !empty($data['installments']) ? $data['installments'] : 1,
                'issuer_id' => 25,
                'payment_method_id' => $data['payment_method_id'],
                'payer' => (object) [
                    'email' => $data['email'],
                    'identification' => (object)[
                        "type" => 'CPF',
                        "number" => $data['cpf']
                    ]
                ],
                'metadata' => (object) [
                    'user_id' => $tenant->uuid,
                    'item' => (object) $plan,
                ],
                'notification_url' => env('MP_URL_NOTIFY')
            ];

            $response = $this->httpClient->post($apiUrl, [
                'headers' => [
                    'Authorization' => "Bearer {$this->access_token}",
                    'content-type' => 'application/json',
                    'accept' => 'application/json'
                ],
                'body' => json_encode($form)
            ]);

            return response()->json($response->getBody()->getContents(), 200);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return response()->json(['message' => 'Falha na transação, tente novamente', 'error' => $e->getResponse()->getBody()->getContents()], 401);
        }
    }

    public function mpNotify(array $data)
    {
    }
}
