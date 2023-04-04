<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TenantResource;
use App\Models\Plan;
use App\Services\CategoryService;
use App\Services\TenantService;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    private $categoryService;
    private $tenant;
    private $tenantService;

    public function __construct(CategoryService $tenant, TenantService $tenantService)
    {
        $this->categoryService = $tenant;
        $this->tenantService = $tenantService;

        $this->middleware(function ($request, $next) {
            $this->tenant = session()->get('tenant');
            return $next($request);
        });
    }

    public function getTenant(Request $request)
    {
        return new TenantResource($this->tenant);
    }

    public function getDeliveryPrice(Request $request)
    {
        if (!$request->cep) {
            return response()->json(['message' => 'Informe um cep'], 400);
        }

        return $this->tenantService->deliveryValue($request->all(), $this->tenant->url);
    }

    public function getPaymentMethods(Request $request) {
        if(!$request->selectedShippingMethod){
            return response()->json(['message' => "informe a forma de entrega"], 400);
        }

        return $this->tenantService->paymentMethos($request->selectedShippingMethod, $this->tenant->url);
    }

    public function getSiteExtensions(Request $request) {
        return $this->tenantService->getSiteExtensions($this->tenant);
    }
}
