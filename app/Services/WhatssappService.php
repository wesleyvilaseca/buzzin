<?php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use GuzzleHttp\Client;

class WhatsappService
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function notifyNewSale()
    {
        $token = 'EAACkyCyQZC5IBAMnK36i3EPjtgaxwEsnr2J6dL7lsNTkaorZCBBi7Ilcp4ID0pfZAGIug5Ec6QLN3Rp5o9p6YsdNQg2P7Se75GXm1e9isFjnzeCVBZBdgnNgeNKEmEu0pdGT20hERNfgvZCVcW1gFGzZBwxlGNZAYjR5t1ZCtOXS796PjVRIeReExt4tqXZAxiiD1Tpvffi30IgZDZD';
        $apiUrl = 'https://graph.facebook.com/v16.0//messages';

        $response = $this->httpClient->request('POST', $apiUrl, [
            'headers' => [
                'Authorization' => "Token token={$token}",
                'Content-Type' => 'application/json'
            ]
        ]);

    }

    public function notifyStatusSaleUpdate()
    {
    }
}
