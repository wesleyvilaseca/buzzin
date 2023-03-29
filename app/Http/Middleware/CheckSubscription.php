<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\TenantService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $tenant = Auth::user()->tenant;
        $isSuper = User::where('email', $tenant->email)->first()->super_admin == 'Y';
        if($isSuper) {
            return $next($request);
        }
        
        if(!$tenant->subscription_active) {
            return Redirect::route('admin.subscriptions');
        }

        return $next($request);
    }
}
