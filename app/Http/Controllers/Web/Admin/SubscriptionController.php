<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Services\MercadoPagoService;
use App\Services\TenantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SubscriptionController extends Controller
{
    private $tenantService;
    private $mercadoPagoService;

    public function __construct(TenantService $tenantService, MercadoPagoService $mercadoPagoService)
    {
        $this->tenantService = $tenantService;
        $this->mercadoPagoService = $mercadoPagoService;

        $this->middleware(function ($request, $next) {
            $status = Auth::user()->tenant->subscription_active;
            if($status == 1) {
                return Redirect::back()->with('warning', 'Sua assinatura está ativa');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $data['title']              = 'Planos';
        $data['toptitle']           = 'Planos';
        $data['subscritions']       = true;
        $data['showSubscriptionMessage'] = 'N';

        return view('admin.subscription.index', $data);
    }

    public function getPlans()
    {
        $plans = Plan::where('status', 1)->with('details')->get();
        return response()->json($plans, 200);
    }

    public function payCard(Request $request)
    {
        return $this->mercadoPagoService->processPlanPaymentCard($request->all());
    }

    public function mpNotify(Request $request)
    {
        return $this->mercadoPagoService->mpNotify($request->all());
    }
}
