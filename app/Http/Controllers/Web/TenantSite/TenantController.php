<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Http\Resources\TenantResource;
use App\Services\CategoryService;
use App\Services\TenantService;
use App\Supports\Helper\Utils;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            $this->tenant = Utils::getCachedTenant();
            return $next($request);
        });
    }

    public function getTenant(Request $request)
    {
        $tenantResorce = Cache::get('tenant-resource-' . $this->tenant->uuid);
        if($tenantResorce) {
            return $tenantResorce;
        }

        $tenantResorce =  new TenantResource($this->tenant);
        Cache::put('tenant-resource-' . $this->tenant->uuid, $tenantResorce, Carbon::now()->addDay());
        return $tenantResorce;
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
