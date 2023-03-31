<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Services\MercadoPagoService;
use App\Services\TenantService;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    private $tenantService;
    private $mercadoPagoService;

    public function __construct(TenantService $tenantService, MercadoPagoService $mercadoPagoService)
    {
        $this->tenantService = $tenantService;
        $this->mercadoPagoService = $mercadoPagoService;
    }

    public function index(Request $request)
    {
        $data['title']              = 'Planos';
        $data['toptitle']           = 'Planos';
        $data['subscritions']       = true;
        $data['showSubscriptionMessage'] = 'N';

        return view('admin.subscription.index', $data);
    }

    public function getPlans() {
        $plans = Plan::where('status', 1)->with('details')->get();
        return response()->json($plans, 200);
    }

    public function payCard(Request $request) {
        return $this->mercadoPagoService->processPayment($request->all());
    }

    public function mpNotify(Request $request) {
        return $this->mercadoPagoService->mpNotify($request->all());
    }
}
