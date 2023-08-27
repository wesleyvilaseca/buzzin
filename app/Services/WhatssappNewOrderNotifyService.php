<?php

namespace App\Services;

use App\Http\Resources\OrderResource;
use App\Models\DashboardExtensionTenant;
use App\Models\Shipping;
use GuzzleHttp\Client;

class WhatssappNewOrderNotifyService
{
    protected $httpClient;
    protected $hasExtencion;
    protected $dataNotifyNewOrder;
    protected $order;
    protected $msg;
    const ALIAS_WHATSAPP_NEW_ORDER_NOTIFY = 'whatsapp_neworder_notify';

    public function __construct()
    {
        $this->httpClient = new Client();
        $this->checkHasExtension();
    }

    public function newOrderNotify($order)
    {
        if (!$this->hasExtencion) {
            return;
        }

        $this->order = json_decode((new OrderResource($order))->toJson());
        $this->getMsgNotify();

        try {
            $apiUrl = "https://graph.facebook.com/v17.0/{$this->dataNotifyNewOrder->sendernumber}/messages";
            $form = [
                "messaging_product" => "whatsapp",
                "recipient_type" => "individual",
                "to" => "55" . celular($this->dataNotifyNewOrder->number),
                "type" => "text",
                "text" => (object) [
                    "preview_url" => false,
                    "body" => $this->msg
                ]
            ];

            $response = $this->httpClient->post($apiUrl, [
                'headers' => [
                    'Authorization' => "Bearer {$this->dataNotifyNewOrder->token}",
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode($form)
            ]);
            $response = json_decode($response->getBody()->getContents());
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // apenas para testes em caso de erro, app não pode parar em caso de falha no envio
            // throw new Error($e->getResponse()->getBody()->getContents());
        }
    }

    private function getMsgNotify()
    {
        $paymentTypeIntegration = function ($order) {
            if ($order->payment_method->integration) {
                switch ($order->order_integration_transaction->payment_type_id) {
                    case 'ticket':
                        return 'Boleto';
                    default:
                        return 'Cartão de crédito';
                }
            }
        };

        $msg = "Buzzin - Uma nova venda foi finalizada\n";
        $msg .= "Identificação do pedido: {$this->order->identify}\n";
        $msg .= "O(s) produto(s) da venda\n";
        $subtotal = 0;

        foreach ($this->order->products as $key => $product) {
            $msg .= "Produto: " . $product->title . "\n";
            $msg .= "Quantidate: " . $product->qty . "\n";
            $msg .= "Valor do produto: " . $product->price . "\n";
            $msg .= "Total: " . $product->qty * $product->price . "\n";
            $msg .= "---------\n\n";

            $subtotal += $product->qty * $product->price;
        }

        $msg .= "Subtotal: {$subtotal}\n";

        $msg .= "Forma de entrega: {$this->order->shipping_method->description}\n";

        if ($this->order->shipping_method->alias !== Shipping::ALIAS_GET_ON_STORE) {
            $msg .= "Valor da entrega: {$this->order->shipping_method->price}\n";
        }

        $msg .= "Total: {$this->order->total}\n\n\n";
        $msg .= "--------------\n";

        if ($this->order->payment_method?->integration) {
            $msg .= "Forma de pagamento: {$this->order->payment_method->integration} - {$paymentTypeIntegration($this->order)}\n";
            $msg .= "Status: {$this->order->order_integration_transaction->status}\n";
        } else {
            $msg .= "Forma de pagamento: {$this->order->payment_method->description}\n";
        }

        $msg .= "Dados do cliente\n";
        $msg .= "Cliente: {$this->order->client->name}\n";
        $msg .= "Email: {$this->order->client->email}\n";
        $msg .= "Celular: " . decript($this->order->client->mobile_phone) . "\n";

        if ($this->order?->shipping_method?->description !== 'Retirada') {
            $msg .= "Endereço: {$this->order->client_address->address}, nº: {$this->order?->client_address?->number} \n";
            $msg .= "Complemento: {$this->order->client_address->complement}\n";
            $msg .= "Bairro: {$this->order->client_address->district}\n";
            $msg .= "CEP: {$this->order->client_address->zip_code}\n";
            $msg .= $this->order->client_address->city . " - " .  $this->order->client_address->state;
        }

        $this->msg = $msg;
    }

    private function checkHasExtension()
    {
        $hasExtension = DashboardExtensionTenant::where([
            'alias' => self::ALIAS_WHATSAPP_NEW_ORDER_NOTIFY,
            'status' => 1
        ])->first();

        if (!$hasExtension) {
            return $this->hasExtencion = false;
        }

        $this->dataNotifyNewOrder = json_decode($hasExtension->data);

        if (!$this->dataNotifyNewOrder?->token) {
            return $this->hasExtencion = false;
        }
        
        $this->hasExtencion = true;
    }
}
