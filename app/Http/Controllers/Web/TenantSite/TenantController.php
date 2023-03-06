<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TenantResource;
use App\Models\Plan;
use App\Services\CategoryService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    private $categoryService;
    private $tenant;
    private $client;

    public function __construct(CategoryService $tenant)
    {
        $this->categoryService = $tenant;
        $this->client = new Client();

        $this->middleware(function ($request, $next) {
            $this->tenant = session()->get('tenant');
            return $next($request);
        });
    }

    public function getTenant(Request $request)
    {
        return new TenantResource($this->tenant);
    }

    public function getDeliveryPrice(Request $request, $cep) {
        if(!$cep) {
            return response()->json(['message' => 'Informe um cep']);
        }

        $apiUrl = "https://www.cepaberto.com/api/v3/cep?cep={$cep}";
        $key = env('MIX_CEP_ABERTO');

        $response = $this->client->request('GET', $apiUrl, [
            'headers' => [
                'Authorization' => "Token token={$key}"
            ]
        ]);

        if($response->getStatusCode() !== 200) {
            return response()->json(['message' => 'Houve um erro na requisição, tente novamento'], 404);
        }

        $res = $response->getBody()->getContents();
        $res = json_decode($res);
        dd($res);
    }
}
