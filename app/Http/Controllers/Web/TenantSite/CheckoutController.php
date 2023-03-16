<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\TenantResource;
use App\Models\Plan;
use App\Services\CategoryService;
use App\Services\OrderService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    private $tenant;
    private $client;
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
        $this->middleware(function ($request, $next) {
            $this->tenant = session()->get('tenant');
            return $next($request);
        });
    }

    public function index()
    {
        $data['title']      = 'Checkout - ' . $this->tenant->url;
        return view('tenant_site.checkout.index', $data);
    }

    public function store(Request $request)
    {
        $data = [];
        $data = $request->all();
        $data['token_company'] = $this->tenant->uuid;
        return $this->orderService->createNewOrder($data);
    }
}
