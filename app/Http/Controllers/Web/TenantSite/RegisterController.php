<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClient;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ClientResource;
use App\Models\Plan;
use App\Services\CategoryService;
use App\Services\ClientService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private $tenant;


    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;

        $this->middleware(function ($request, $next) {
            $this->tenant = session()->get('tenant');
            return $next($request);
        });
    }

    public function index()
    {
        $data['title']      = 'Registro - ' . $this->tenant->url;
        return view('tenant_site.register.index', $data);
    }

    public function store(StoreClient $request)
    {
        $client = $this->clientService->createNewClient($request->all());
        return new ClientResource($client);
    }

    public function me(Request $request)
    {
        $client = $request->user();

        return new ClientResource($client);
    }
}
