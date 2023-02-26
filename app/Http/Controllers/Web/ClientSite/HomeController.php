<?php

namespace App\Http\Controllers\Web\ClientSite;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Site;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $tenantRepository;
    private $tenant;

    public function __construct(Tenant $tenantRepository)
    {
        $subdomain = explode(".", request()->getHttpHost())[0];
        $this->tenantRepository = $tenantRepository;
        $this->tenant = $this->tenantRepository = Tenant::where('url', $subdomain)->first();
    }

    public function index()
    {
        $data['title']      = 'Home - ' . $this->tenant->url;
        return view('client_site.home.index', $data);
    }

    public function inMaintence()
    {
        $data['title']      = 'Em Manutenção - ' . $this->tenant->url;
        return view('client_site.maintence.index', $data);
    }
}
