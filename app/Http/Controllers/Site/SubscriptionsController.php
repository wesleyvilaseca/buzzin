<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTenant;
use App\Models\Plan;
use App\Services\TenantService;
use Illuminate\Support\Facades\Redirect;

class SubscriptionsController extends Controller
{
    public function plan($url)
    {
        $plan = Plan::where('url', $url)->first();
        if (!$plan)
            return Redirect::back();

        session()->put('plan', $plan);

        $data['title'] = 'Assinatura plano ' . $plan->name;
        $data['toptitle'] = 'Assinatura plano ' . $plan->name;
        $data['plan'] = $plan;
        return view('site.subscriptions.index', $data);
    }

    public function register(StoreUpdateTenant $request, string $url)
    {
        $plan = Plan::where('url', $url)->first();
        if (!$plan)
            return Redirect::back();

        $tenant_service = app(TenantService::class);
        
        $tenant_service->make($plan, $request->all());

        return redirect()->route('login')->with('success', 'Usuario criado com sucesso');
    }
}
