<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\PaymentIntegration\MercadoPagoAdminService;
use Illuminate\Http\Request;

class TransactionNotificationController extends Controller
{
    private $mercadoPagoService;

    public function __construct(MercadoPagoAdminService $mercadoPagoService)
    {
        $this->mercadoPagoService = $mercadoPagoService;
    }

    public function mpNotify(Request $request)
    {
        return $this->mercadoPagoService->mpNotifyPlan($request->all());
    }
}
