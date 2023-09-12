<?php

namespace App\Http\Middleware;

use App\Models\Site;
use App\Models\TenantSites;
use App\Supports\Cripto\Cripto;
use App\Supports\Helper\Utils;
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
        $host = str_replace('www.', '', request()->getHttpHost());
        $notEnableSite = Utils::getSite($host);
        if($notEnableSite) {
            return $notEnableSite;
        }

        return $next($request);
    }
}
