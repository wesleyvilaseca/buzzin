<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Supports\Cripto\Cripto;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ClientSiteAccess
{
    use Cripto;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // session()->forget('adminlogin');
        // dd($request->session()->get('adminlogin'));
        $appdomain = env('APP_URL');
        $subdomain = explode(".", request()->getHttpHost())[0];
        $tenantExist = Tenant::where('url', $subdomain)->first();

        if (!$tenantExist) {
            return Redirect::to($appdomain);
        }

        $site = $tenantExist->site()->first();
        if (!$site) {
            return Redirect::to($appdomain);
        }

        $isEnabladByAdmin = $site->status;
        switch ($isEnabladByAdmin) {
            case 0:
                //is not enabled
                return Redirect::to($appdomain);
                break;
            case 2:
                //is block by adm
                return dd('in maintence');
                break;
        }

        $hasParams = @$_GET['params'];
        $isInMaintence = $site->maintence;

        if ($isInMaintence == 1 && !$hasParams && !$request->session()->get('adminlogin')) {
            return Redirect::route('tenant.maintence');
        }

        if (@$hasParams) {
            $params = Cripto::decrypt($hasParams);
            if ($params->domain !== request()->getHttpHost()) {
                return Redirect::to($appdomain);
            }
        }

        if ($hasParams && ($params->domain == request()->getHttpHost())) {
            session()->put('adminlogin', 'S');
        }

        return $next($request);
    }
}
