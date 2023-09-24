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
        if (!$site || ($site->status !== Site::STATUS_APROVED)) {
            return null;
        }

        $hasDomain = $site->status_domain == Site::STATUS_DOMAIN_APROVED;
        if ($hasDomain) {
            return $site->domain;
        }

        return $site->subdomain;
    }

    public static function getSite($host)
    {
        $appdomain = env('APP_URL');
        $isDomain = true;
        if (Str::contains($host, str_replace(['http://', 'https://'], '', $appdomain))) {
            $isDomain = false;
        }

        if ($isDomain) {
            $site = TenantSites::where([
                'domain' => $host,
                'status_domain' => Site::STATUS_APROVED
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
            case Site::STATUS_WAITING:
                //is not enabled
                return Redirect::to($appdomain);
                break;
            case Site::STATUS_DISABLED:
                //is block by adm
                return dd('in maintence');
                break;
        }

        $isInMaintence = $site->maintence;
        if ($isInMaintence == Site::IN_MAINTENCE) {
            $userAdmin = User::where('email', $tenant->email)->first();
            if(!Cache::has('user-is-online-' . $userAdmin->id)) {
                return Redirect::route('tenant.maintence');
            }else {
                Cache::put('user-is-online-' . $userAdmin->id, true, Carbon::now()->addMinutes(5));
            }
        }
    }
}
