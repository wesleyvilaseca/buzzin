<?php

namespace App\Http\Controllers\Web\Site;

use App\Events\TenantCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTenant;
use App\Models\Plan;
use App\Services\TenantService;
use Illuminate\Support\Facades\Redirect;

use function Psy\debug;

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
        $user = $tenant_service->make($plan, $request->all());

        event(new TenantCreated($user));

        return redirect()->route('login')->with('success', 'Registro efetuado com sucesso');
    }
}
