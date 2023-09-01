<?php

namespace App\Http\Controllers\Web\Site;

use App\Events\TenantCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTenant;
use App\Models\Plan;
use App\Services\TenantService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SubscriptionsController extends Controller
{
    public function __construct()
    {
        $disabled_online_sign = env('DISABLE_AUTO_SIGN');
        if ($disabled_online_sign) {
            $this->middleware(['can:subscription']);
        }
    }

    public function plan($url)
    {
        $plan = Plan::where('url', $url)->first();
        if (!$plan) {
            return Redirect::back();
        }

        session()->put('plan', $plan);

        $data['title'] = 'Assinatura plano ' . $plan->name;
        $data['toptitle'] = 'Assinatura plano ' . $plan->name;
        $data['plan'] = $plan;
        return view('site.subscriptions.index', $data);
    }

    public function register(StoreUpdateTenant $request, string $url)
    {

        DB::beginTransaction();
        try {

            $plan = Plan::where('url', $url)->first();
            if (!$plan) {
                return Redirect::back();
            }

            $tenant_service = app(TenantService::class);
            $user = $tenant_service->make($plan, $request->all());
            event(new TenantCreated($user));

            DB::commit();
            return redirect()->route('login')->with('success', 'Registro efetuado com sucesso');
        } catch (Exception $e) {
            DB::rollback();
            return Redirect::back()
                ->with('error', $e->getMessage())
                ->withInput($request->except('password'));
        }
    }
}
