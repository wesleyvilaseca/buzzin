<?php

namespace App\Supports\Helper;

use App\Models\Site;
use App\Models\TenantSites;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class Utils
{
    public static function getSiteTenantLink()
    {
        if (!Auth::check()) {
            return null;
        }

        $tenant = Auth::user()->tenant;
        $site = $tenant->site->first();

        if (!$site) {
            return null;
        }
        //has domain and is implements
        if ($site->status_domain == Site::STATUS_DOMAIN_APROVED) {
            return $site->domain;
        }

        //status subdoamin and check if is aproved
        if ($site->status == Site::STATUS_APROVED) {
            return $site->subdomain;
        }

        /**
         * aqui no admin, sempre vou direcionar para a URL
         */
        // $hasSubdomain = $site->subdomain && $site->status == Site::STATUS_APROVED;

        // $hasDomain = $site->domain && $site->status_domain == Site::STATUS_DOMAIN_APROVED;
        // if ($hasDomain) {
        //     return $site->domain;
        // }

        // return $site->subdomain;

        //default route tenant site
        return request()->getHttpHost() . '/' . $site->url;
    }

    public static function getCachedTenant() {

        // $domain = request()->getHttpHost();
        // $url = explode('/', str_replace(['http://', 'https://'], "", request()->url()));

        // $isTenantSiteDomainOrSubDomain = Cache::get('tenant-site-' . $domain);
        // $isDefaultPrefixDomain =  Cache::get(isset($url[1]) ? 'tenant-site-' . $url[1] : null);

        // if ($isTenantSiteDomainOrSubDomain) {
        //     return Cache::get('tenant-' . $isTenantSiteDomainOrSubDomain->tenant->uuid);
        // } else {
        //     return Cache::get('tenant-' . $isDefaultPrefixDomain->tenant->uuid);
        // }

        return Cache::get('tenant-' . session()->get('tenant_key'));
    }

    public static function getSite($host, $url = null, $redirectOnMaintence = false)
    {
        $appdomain = env('APP_URL');
        $isDomain = true;
        if (Str::contains($host, str_replace(['http://', 'https://'], '', $appdomain))) {
            $isDomain = false;
        }

        $site = Cache::get($isDomain ? 'tenant-site-' . $host : 'tenant-site-' . $url);

        if(!$site) {
            if ($isDomain) {
                $site = TenantSites::where([
                    'domain' => $host,
                    // 'status_domain' => Site::STATUS_APROVED
                ])->first();
                Cache::put('tenant-site-' . $host, $site, Carbon::now()->addDay());
            } else {
                $site = TenantSites::where([
                    'subdomain' => $host,
                ])->first();
    
                Cache::put('tenant-site-' . $host, $site, Carbon::now()->addDay());
                if (!$site && $url) {
                    $site = TenantSites::where([
                        'url' => $url,
                    ])->first();
                    Cache::put('tenant-site-' . $url, $site, Carbon::now()->addDay());
                }
            }
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

        Cache::put('tenant-' . $tenant->uuid, $tenant,  Carbon::now()->addDay());
        session()->put('tenant_key', $tenant->uuid);

        if($redirectOnMaintence) {
            $isInMaintence = $site->maintence;
            if ($isInMaintence == Site::IN_MAINTENCE) {
                $userAdmin = User::where('email', $tenant->email)->first();
                if(!Cache::has('user-is-online-' . $userAdmin->id)) {
                    return redirect()->route('tenant.maintence');
                }else {
                    Cache::put('user-is-online-' . $userAdmin->id, true, Carbon::now()->addMinutes(5));
                }
            }
        }

        if ($isDomain) {
            $isEnabladByAdmin = $site->status;
            switch ($isEnabladByAdmin) {
                case Site::STATUS_WAITING:
                    //is not enabled
                    return Redirect::to($appdomain);
                    break;
                case Site::STATUS_DISABLED:
                    //is block by adm
                    return redirect()->route('tenant.maintence');
                    break;
            }
        }
    }
}
