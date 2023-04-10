<?php

namespace App\Services;

use App\Models\Plan;
use App\Models\Tenant;
use App\Models\Transaction;
use App\Repositories\Contracts\TableRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MercadoPagoService
{
    protected $httpClient;
    private $access_token;
    private $tenantService;
    const APPROVED = 'approved';

    public function __construct(TenantService $tenantService)
    {
        $this->httpClient = new Client();
        $this->access_token = env('MP_PRODUCTION') ? env('MERCADO_PAGO_TOKEN') : env('MERCADO_PAGO_SANDBOX_TOKEN');
        $this->tenantService = $tenantService;
    }

    public function processPlanPaymentCard(array $data)
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

            $data = (object) [
                'item' => $response->metadata->item
            ];

            $response = json_decode($response->getBody()->getContents());
            Transaction::create([
                'type_transaction' => 'subscription',
                'data' => json_encode($data),
                'transaction_id' => $response->id,
                'transaction_amount' => $response->transaction_amount,
                'last_four_digits' => $response->card->last_four_digits,
                'payment_method_id' => $response->payment_method_id,
                'payment_type_id' => $response->payment_type_id,
                'status' => $response->status,
                'status_detail' => $response->status_detail,
                'external_resource_url' => $response->transaction_details->external_resource_url
            ]);

            if ($response->status == self::APPROVED) {
                $this->tenantService->updateAssignatureRenew($response->id, $plan);
            }

            return response()->json(['message' => 'Transação efetuada com sucesso', 'redirect' => route('admin.transactions')], 200);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return response()->json(['message' => 'Falha na transação, tente novamente', 'error' => $e->getResponse()->getBody()->getContents()], 401);
        }
    }

    public function payslip(array $data)
    {
        $plan = Plan::find($data['plan_id']);
        if (!$plan) {
            return response()->json(['message' => 'Operação não autorizada'], 401);
        }

        if (!validaCPF($data['cpf'])) {
            $errors['cpf'][] = 'O CPF informado é inválido';
            return response()->json((object) ["errors" => $errors], 400);
        }

        try {
            $tenant = Auth::user()->tenant;
            $apiUrl = 'https://api.mercadopago.com/v1/payments';

            $form = [
                'external_reference' => $tenant->uuid,
                'transaction_amount' => (float) $plan->price,
                'description' => $plan->name,
                'payment_method_id' => 'bolbradesco',
                'payer' => (object) [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
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

            $response = json_decode($response->getBody()->getContents());

            $data = (object) [
                'item' => $response->metadata->item
            ];

            Transaction::create([
                'type_transaction' => 'subscription',
                'data' => json_encode($data),
                'transaction_id' => $response->id,
                'transaction_amount' => $response->transaction_amount,
                'payment_method_id' => $response->payment_method_id,
                'payment_type_id' => $response->payment_type_id,
                'status' => $response->status,
                'status_detail' => $response->status_detail,
                'barcode' => $response->barcode->content,
                'external_resource_url' => $response->transaction_details->external_resource_url
            ]);

            return response()->json(['message' => 'Boleto gerado com sucesso', 'redirect' => route('admin.transactions')], 200);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return response()->json(['message' => 'Falha na transação, tente novamente', 'error' => $e->getResponse()->getBody()->getContents()], 401);
        }
    }

    public function payPix(array $data)
    {
        $plan = Plan::find($data['plan_id']);
        if (!$plan) {
            return response()->json(['message' => 'Operação não autorizada'], 401);
        }

        if (!validaCPF($data['cpf'])) {
            $errors['cpf'][] = 'O CPF informado é inválido';
            return response()->json((object) ["errors" => $errors], 400);
        }

        try {
            $tenant = Auth::user()->tenant;
            $apiUrl = 'https://api.mercadopago.com/v1/payments';

            $form = [
                'external_reference' => $tenant->uuid,
                'transaction_amount' => (float) $plan->price,
                'description' => $plan->name,
                'payment_method_id' => 'pix',
                'payer' => (object) [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
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

            $response = json_decode($response->getBody()->getContents());

            $data = (object) [
                'qrcode64' => $response->point_of_interaction->transaction_data->qr_code_base64,
                'qrcode' => $response->point_of_interaction->transaction_data->qr_code,
                'item' => $response->metadata->item
            ];

            Transaction::create([
                'type_transaction' => 'subscription',
                'data' => json_encode($data),
                'transaction_id' => $response->id,
                'transaction_amount' => $response->transaction_amount,
                'payment_method_id' => $response->payment_method_id,
                'payment_type_id' => $response->payment_type_id,
                'status' => $response->status,
                'status_detail' => $response->status_detail,
                'external_resource_url' => $response->transaction_details->external_resource_url
            ]);

            return response()->json(['message' => 'Pix gerado com sucesso', 'redirect' => route('admin.transactions'), 'data' => $data ], 200);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return response()->json(['message' => 'Falha na transação, tente novamente', 'error' => $e->getResponse()->getBody()->getContents()], 401);
        }
    }

    public function mpNotifyPlan(array $data)
    {
        Log::info(['payment' => $data]);
        $dataMp = $data['data'];
        if (!$data['type'] && !$dataMp['id']) {
            return response()->json(['message' => 'Operação não autorizada'], 403);
        }

        if ($data['type'] == 'payment') {
            try {
                $apiUrl = 'https://api.mercadopago.com/v1/payments/' . $dataMp['id'];
                $response = $this->httpClient->get($apiUrl, [
                    'headers' => [
                        'Authorization' => "Bearer {$this->access_token}",
                        'content-type' => 'application/json',
                        'accept' => 'application/json'
                    ]
                ]);

                $response = json_decode($response->getBody()->getContents());

                $tenant = Tenant::where('uuid', $response->metadata->user_id)->first();

                $transaction = Transaction::where([
                    'transaction_id' => $response->id,
                    'tenant_id' => $tenant->id
                ])->first();

                if (!$transaction) {
                    Log::info(['error_payment' => 'transação não localizada']);
                    return response()->json(['message' => 'transação não localizada'], 401);
                }

                $transaction->update([
                    'status' => $response->status,
                    'status_detail' => $response->status_detail
                ]);

                if ($response->status == self::APPROVED) {
                    $plan = Plan::find($response->item->id);
                    $this->tenantService->updateAssignatureRenew($response->id, $plan);
                }

                return response()->json(['message' => 'transação atualização com sucesso'], 200);
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                Log::info(['error_payment' => $e->getResponse()->getBody()->getContents()]);
                return response()->json(['message' => 'Falha na requisição', 'error' => $e->getResponse()->getBody()->getContents()], 401);
            }
        }
    }
}
