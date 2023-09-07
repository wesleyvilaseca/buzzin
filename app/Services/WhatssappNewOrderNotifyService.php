<?php

namespace App\Services;

use App\Http\Resources\OrderResource;
use App\Models\DashboardExtensionTenant;
use App\Models\Order;
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

    public function newOrderNotify(Order $order)
    {
        if (!$this->hasExtencion) {
            return;
        }

        $this->order = $order;
        $this->getMsgNotify();

        try {
            $apiUrl = "https://graph.facebook.com/v17.0/{$this->dataNotifyNewOrder->sendernumber}/messages";
            $form = [
                "messaging_product" => "whatsapp",
                "recipient_type" => "individual",
                "to" => "55" . celular($this->dataNotifyNewOrder->number),
                "type" => "template",
                "template" => (object) [
                    "language" => (object) ["code" => "pt_BR"],
                    "name" => $this->dataNotifyNewOrder->template,
                    "components" => [
                        (object)[
                            "type" => "header",
                            "parameters" => [
                                (object) [
                                    "type" => "document",
                                    "document" => (object) [
                                        "link" => getFileLink($this->order->data->pdfFileDetailsOrder),
                                        "filename" => 'venda ' . $this->order->identify
                                    ]
                                ]
                            ]
                        ],
                        (object) [
                            "type" => "body",
                            "parameters" => [
                                (object) [
                                    "type" => "text",
                                    "text" => $this->order->tenant->name
                                ]
                            ]
                        ]
                    ]
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
        $this->msg = 'oi';
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
