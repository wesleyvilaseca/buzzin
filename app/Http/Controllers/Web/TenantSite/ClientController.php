<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Plan;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ClientController extends Controller
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
        $data['title']      = 'Área do client - ' . $this->tenant->url;
        return view('tenant_site.client.index', $data);
    }
}
