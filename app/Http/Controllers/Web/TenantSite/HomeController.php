<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Inertia\Inertia;

class HomeController extends Controller
{
    private $tenant;

    public function __construct(Tenant $tenantRepository)
    {
        $this->middleware(function ($request, $next) {
            $this->tenant = session()->get('tenant');
            return $next($request);
        });
    }

    public function index()
    {
        $data['title']      = 'Home - ' . $this->tenant->url;
        Inertia::setRootView('layouts.tenant_site.site');
        return Inertia::render('tenant_site/home/home.view.vue', $data);
    }

    public function inMaintence()
    {
        $data['title']      = 'Em Manutenção - ' . $this->tenant->url;
        Inertia::setRootView('layouts.tenant_site.site');
        return Inertia::render('tenant_site/maintence/maintence.view.vue', $data);
    }
}
