<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Services\MercadoPagoService;
use App\Services\TenantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TransactionNotificationController extends Controller
{
    private $mercadoPagoService;

    public function __construct(TenantService $tenantService, MercadoPagoService $mercadoPagoService)
    {
        $this->mercadoPagoService = $mercadoPagoService;
    }

    public function mpNotify(Request $request)
    {
        return $this->mercadoPagoService->mpNotifyPlan($request->all());
    }
}
