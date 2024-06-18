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
        $url = explode('/', str_replace(['http://', 'https://'], "", request()->url()));

        $notEnableSite = Utils::getSite($host, isset($url[1]) ? $url[1] : null, true);
        if($notEnableSite) {
            return $notEnableSite;
        }

        return $next($request);
    }
}
