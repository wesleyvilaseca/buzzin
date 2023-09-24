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
use Inertia\Inertia;

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
        Inertia::setRootView('tenant_site.recover.index');
        return Inertia::render('tenant_site/recover/recover.view.vue', $data);
    }

    public function pagePasswordReset(Request $request, $token)
    {
        $data['title']      = 'Nova senha';
        $data['token']      = $token;
        $data['email']      = $request->get("email");
        Inertia::setRootView('tenant_site.password_reset.index');
        return Inertia::render('tenant_site/password_reset/password_reset.view.vue', $data);
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
