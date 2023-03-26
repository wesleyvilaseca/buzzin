<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderClientResource;
use App\Services\OrderService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $tenant;
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
        $data['title']      = 'Área do cliente - ' . $this->tenant->url;
        return view('tenant_site.client.index', $data);
    }

    public function getOrders(Request $request)
    {
        $orders = $this->orderService->ordersByClientByTenant($this->tenant->id);
        return OrderClientResource::collection($orders);
    }
}
