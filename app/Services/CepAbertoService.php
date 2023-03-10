<?php

namespace App\Services;

use App\Repositories\Contracts\TableRepositoryInterface;
use App\Repositories\Contracts\TenantRepositoryInterface;
use Exception;
use GuzzleHttp\Client;

class CepAbertoService
{
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client();
    }

    public function getCep(string $cep, bool $returnResponse = true)
    {
        $apiUrl = "https://www.cepaberto.com/api/v3/cep?cep={$cep}";
        $key = env('MIX_CEP_ABERTO');

        $response = $this->httpClient->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => "Token token={$key}"
            ]
        ]);

        if ($response->getStatusCode() !== 200 && $returnResponse) {
            return response()->json(['message' => 'Houve um erro na requisição, tente novamento'], 404);
        }

        if ($response->getStatusCode() !== 200 && !$returnResponse) {
            throw new Exception('Cep não localizado', $response->getStatusCode());
        }

        $res = $response->getBody()->getContents();
        return json_decode($res);
    }
}
