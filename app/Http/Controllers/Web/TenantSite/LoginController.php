<?php

namespace App\Http\Controllers\Web\TenantSite;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateClientAddress;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Services\ClientAddressService;
use App\Supports\Helper\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class LoginController extends Controller
{
    private $tenant;
    private $clientAddressService;

    public function __construct(ClientAddressService $clientAddressService)
    {
        $this->clientAddressService = $clientAddressService;
        $this->middleware(function ($request, $next) {
            $this->tenant = Utils::getCachedTenant();
            return $next($request);
        });
    }

    public function index()
    {
        $data['title']      = 'Login - ' . $this->tenant->url;
        Inertia::setRootView('tenant_site.login.index');
        return Inertia::render('tenant_site/login/login.view.vue', $data);
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $client = Client::where('email', $request->email)->first();

        if (!$client || !Hash::check($request->password, $client->password)) {
            return response()->json(['message' => trans('messages.invalid_credentials')], 404);
        }

        $token = $client->createToken($request->device_name)->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function me(Request $request)
    {
        $client = $request->user();

        return new ClientResource($client);
    }

    public function getClientAddress(Request $request)
    {
        return $this->clientAddressService->getClientAddress(Auth::user()->id);
    }

    public function saveNewAddress(StoreUpdateClientAddress $request)
    {
        $data = $request->all();
        $data['client_id'] = Auth::user()->id;

        return $this->clientAddressService->createNewAddress($data);
    }

    public function logout(Request $request)
    {
        $client = $request->user();
        $client->tokens()->delete();

        return response()->json([], 204);
    }
}
