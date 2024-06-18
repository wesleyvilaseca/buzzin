<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderClientResource;
use App\Services\ClientAddressService;
use App\Services\ClientService;
use App\Services\OrderService;
use App\Supports\Helper\Utils;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClientController extends Controller
{
    private $tenant;
    private $orderService;
    private $clientAddressService;
    private $clientService;

    public function __construct(OrderService $orderService, ClientAddressService $clientAddressService, ClientService $clientService)
    {
        $this->orderService = $orderService;
        $this->clientAddressService = $clientAddressService;
        $this->clientService = $clientService;

        $this->middleware(function ($request, $next) {
            $this->tenant = Utils::getCachedTenant();
            return $next($request);
        });
    }

    public function index()
    {
        $data['title']      = 'Área do cliente - ' . $this->tenant->url;
        Inertia::setRootView('layouts.tenant_site.site');
        return Inertia::render('tenant_site/client/index.view.vue', $data);
    }

    public function getOrders(Request $request)
    {
        $orders = $this->orderService->ordersByClientByTenant($this->tenant->id);
        return OrderClientResource::collection($orders);
    }

    public function updateAddress(Request $request, $id)
    {
        return $this->clientAddressService->updateAddress($request->all(), $id);
    }

    public function deleteAddress(Request $request, $id)
    {
        return $this->clientAddressService->deleteAddress($id);
    }

    public function updateAccount(Request $request)
    {
        return $this->clientService->update($request->all());
    }

    public function updatePasswordAccount(Request $request)
    {
        return $this->clientService->updatePasswordAccount($request->all());
    }
}
