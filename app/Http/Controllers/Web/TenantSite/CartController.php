<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Plan;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    private $tenant;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->tenant = session()->get('tenant');
            return $next($request);
        });
    }

    public function index()
    {
        $data['title']      = 'Carrinho de compras - ' . $this->tenant->url;
        Inertia::setRootView('layouts.tenant_site.site');
        return Inertia::render('tenant_site/cart/cart.view.vue', $data);
    }

}
