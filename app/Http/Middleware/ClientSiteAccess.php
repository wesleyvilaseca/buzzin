<?php

namespace App\Http\Middleware;

use App\Models\TenantSites;
use App\Supports\Cripto\Cripto;
use Biscolab\ReCaptcha\ReCaptchaBuilder;
use Biscolab\ReCaptcha\ReCaptchaServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

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
        $appdomain = env('APP_URL');
        $host = str_replace('www.', '', request()->getHttpHost());
        $isDomain = true;

        if (Str::contains($host, str_replace(['http://', 'https://'], '', $appdomain))) {
            $isDomain = false;
        }

        if ($isDomain) {
            $site = TenantSites::where([
                'domain' => $host,
                'status_domain' => 1
            ])->first();
        } else {
            $site = TenantSites::where([
                'subdomain' => $host,
            ])->first();
        }

        if (!$site) {
            return Redirect::to($appdomain);
        }

        $site->isDomain = $isDomain;
        $site->hasRecaptcha = false;
        if ($isDomain) {
            $hasRecaptcha = @$site->recaptcha_key && @$site->recaptcha_secret_key;

            if ($hasRecaptcha) {

                config([
                    'recaptcha.api_site_key' => $site->recaptcha_key,
                    'recaptcha.api_secret_key' => $site->recaptcha_secret_key,
                ]);
            }

            $site->hasRecaptcha = $hasRecaptcha;
        }

        $tenant = $site->tenant;
        $tenant->site = $site;

        session()->put('tenant', $tenant);

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
