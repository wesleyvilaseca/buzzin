<?php

namespace App\Services\PaymentIntegration;

use App\Models\Order;
use App\Models\OrderIntegrationTransation;
use App\Models\Payment;
use App\Models\Tenant;
use App\Models\TenantPayment;
use App\Services\TenantService;
use Error;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MercadoPagoOrderPaymentService
{
    private $tenantService;
    private $tenantConfigPayment;
    private $order;
    private $paymentClientDetail;
    protected $httpClient;

    public const INTEGRATION = 'MercadoPago';
    public const APPROVED = 'approved';

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
        $this->httpClient = new Client();
    }

    public function startPayment(Order $order, $data)
    {
        $this->order = $order;
        $this->paymentClientDetail = $data['payment_integration_params'];
        $this->setPaymentTenantConfig();

        switch ($this->paymentClientDetail['payment_method_id']) {
            case 'slip':
                return $this->slip();

            default:
                if ($this->paymentClientDetail['token']) return $this->creditCard();
        }
    }

    private function setPaymentTenantConfig()
    {
        $paymentMethodId = Payment::where('integration', self::INTEGRATION)->first()->id;
        $config = TenantPayment::where([
            'tenant_id' => $this->order->tenant->id,
            'payment_id' => $paymentMethodId
        ])->first();

        $this->tenantConfigPayment = json_decode($config->data);
    }

    private function slip()
    {

        try {
            $apiUrl = 'https://api.mercadopago.com/v1/payments';

            $form = [
                'external_reference' => $this->order->client_id,
                'transaction_amount' => (float) $this->order->total,
                'description' => 'Compra online ' . $this->order->tenant->name,
                'payment_method_id' => 'bolbradesco',
                'payer' => (object) [
                    'first_name' => $this->paymentClientDetail['first_name'],
                    'last_name' => $this->paymentClientDetail['last_name'],
                    'email' => $this->paymentClientDetail['email'],
                    'identification' => (object)[
                        "type" => 'CPF',
                        "number" => $this->paymentClientDetail['cpf']
                    ]
                ],
                'metadata' => (object) [
                    'user_id' => $this->order->client_id,
                    'itens' => $this->order->products
                ],
                'notification_url' => env('MP_URL_NOTIFY_ORDER')
            ];

            $response = $this->httpClient->post($apiUrl, [
                'headers' => [
                    'Authorization' => "Bearer {$this->tenantConfigPayment->access_token}",
                    'content-type' => 'application/json',
                    'accept' => 'application/json'
                ],
                'body' => json_encode($form)
            ]);

            $response = json_decode($response->getBody()->getContents());

            $data = (object) [
                'itens' => $response->metadata->itens
            ];

            $res = OrderIntegrationTransation::create([
                'order_id' => $this->order->id,
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

            return $res;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw new Error($e->getResponse()->getBody()->getContents());
        }
    }

    private function creditCard()
    {
        $apiUrl = 'https://api.mercadopago.com/v1/payments';

        try {

            $form = [
                'external_reference' => $this->order->client_id,
                'transaction_amount' => (float) $this->order->total,
                'payment_method_id' => $this->paymentClientDetail['payment_method_id'],
                'token' => $this->paymentClientDetail['token'],
                'description' => 'Compra online ' . $this->order->tenant->name,
                'installments' => !empty($this->paymentClientDetail['installments']) ? (int) $this->paymentClientDetail['installments'] : 1,
                'issuer_id' => 25,
                'payer' => (object) [
                    'email' => $this->paymentClientDetail['email'],
                    'identification' => (object)[
                        "type" => 'CPF',
                        "number" => $this->paymentClientDetail['cpf']
                    ]
                ],
                'metadata' => (object) [
                    'user_id' => $this->order->client_id,
                    'itens' => $this->order->products
                ],
                'notification_url' => env('MP_URL_NOTIFY_ORDER')
            ];

            $response = $this->httpClient->post($apiUrl, [
                'headers' => [
                    'Authorization' => "Bearer {$this->tenantConfigPayment->access_token}",
                    'content-type' => 'application/json',
                    'accept' => 'application/json'
                ],
                'body' => json_encode($form)
            ]);

            $response = json_decode($response->getBody()->getContents());

            $data = (object) [
                'itens' => $response->metadata->itens
            ];

            $res = OrderIntegrationTransation::create([
                'order_id' => $this->order->id,
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

            return $res;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            throw new Error($e->getResponse()->getBody()->getContents());
        }
    }

    private function pix()
    {
    }

    public function mpNotify(array $data)
    {
        Log::info(['payment' => $data]);
        $dataMp = $data['data'];
        if (!$data['type'] && !$dataMp['id']) {
            return response()->json(['message' => 'Operação não autorizada'], 403);
        }

        $transaction = OrderIntegrationTransation::where('transaction_id', $dataMp['id'])->first();

        if (!$transaction) {
            return response()->json(['message' => 'transação não localizada'], 401);
        }

        if ($data['type'] != 'payment') {
            return response()->json(['message' => 'Operação não autorizada'], 401);
        }

        try {
            $this->order = $transaction->order;
            $this->setPaymentTenantConfig();

            $apiUrl = 'https://api.mercadopago.com/v1/payments/' . $dataMp['id'];
            $response = $this->httpClient->get($apiUrl, [
                'headers' => [
                    'Authorization' => "Bearer {$this->tenantConfigPayment->access_token}",
                    'content-type' => 'application/json',
                    'accept' => 'application/json'
                ]
            ]);

            $response = json_decode($response->getBody()->getContents());

            // $tenant = Tenant::where('uuid', $response->metadata->user_id)->first();

            // $transaction = Transaction::where([
            //     'transaction_id' => $response->id,
            //     'tenant_id' => $tenant->id
            // ])->first();

            if (!$transaction) {
                Log::info(['error_payment' => 'transação não localizada']);
                return response()->json(['message' => 'transação não localizada'], 401);
            }

            $transaction->update([
                'status' => $response->status, #'approved',
                'status_detail' => $response->status_detail, #'accredited',
            ]);

            return response()->json(['message' => 'transação atualização com sucesso'], 200);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            Log::info(['error_payment' => $e->getResponse()->getBody()->getContents()]);
            return response()->json(['message' => 'Falha na requisição', 'error' => $e->getResponse()->getBody()->getContents()], 401);
        }
    }
}
