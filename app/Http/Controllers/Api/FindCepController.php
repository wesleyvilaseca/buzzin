<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TenantRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use App\Services\CepAbertoService;
use Exception;
use Facade\Ignition\Http\Controllers\ExecuteSolutionController;
use Illuminate\Http\Request;

class FindCepController extends Controller
{
    private $cepAbertoService;

    public function __construct(CepAbertoService $cepAbertoService)
    {
        $this->cepAbertoService = $cepAbertoService;
    }

    public function getCep($cep)
    {
        try {
            $res = $this->cepAbertoService->getCep(unMaskCPF($cep));
            return response()->json($res);
        } catch (Exception $e) {
            return response()->json(['error' => 'falha na consulta do cep'], 422);
        }
    }
}
