<?php

namespace App\Services\PaymentIntegration;

use App\Models\Order;
use App\Models\OrderIntegrationTransation;
use App\Services\TenantService;
use Error;
use GuzzleHttp\Client;

class MercadoPagoOrderPaymentService
{
    private $tenantService;
    private $tenantConfigPayment;
    private $order;
    private $paymentClientDetail;
    protected $httpClient;

    public const INTEGRATION = 'MercadoPago';

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
        $this->httpClient = new Client();
    }

    public function startPayment(Order $order)
    {
        $this->order = $order;
        $this->order->data = json_decode($this->order->data);
        $paymentConfig = $this->order->data->payment_method;

        $this->tenantConfigPayment = json_decode($paymentConfig->data);
        $this->paymentClientDetail = $this->order->data->payment_integration_params;

        switch ($this->paymentClientDetail->payment_method_id) {
            case 'slip':
                return $this->slip();

            default:
                # cridit
                break;
        }
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
                    'first_name' => $this->paymentClientDetail->first_name,
                    'last_name' => $this->paymentClientDetail->last_name,
                    'email' => $this->paymentClientDetail->email,
                    'identification' => (object)[
                        "type" => 'CPF',
                        "number" => $this->paymentClientDetail->cpf
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
    }

    private function pix()
    {
    }
}
