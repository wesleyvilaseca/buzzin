<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateClientAddress;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountRecoverLoginController extends Controller
{
    private $tenant;
    private $clientService;

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
        $data['title']      = 'Recuperar acesso - ' . $this->tenant->url;
        return view('tenant_site.recover.index', $data);
    }

    public function pagePasswordReset(Request $request, $token)
    {
        $data['title']      = 'Nova senha';
        $data['token']      = $token;
        $data['email']      = $request->get("email");
        return view('tenant_site.password_reset.index', $data);
    }

    public function sendRecover(Request $request)
    {
        return $this->clientService->sendRecoverPassord($request->all(), $this->tenant);
    }

    public function resetPassword(Request $request)
    {
        return $this->clientService->resetPassword($request->all());
    }
}
