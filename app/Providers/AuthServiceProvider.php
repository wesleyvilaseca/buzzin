<?php

namespace App\Providers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerPolicies();

        $this->registerPolicies();
        if ($this->app->runningInConsole()) return;

        $permissions = Permission::all();

        foreach ($permissions as $permission) {
            Gate::define($permission->description, function (User $user) use ($permission) {
                // $user->internal = 1;
                return $user->hasPermission($permission->description);
            });
        }


        // Permission::all()->map(function ($permission){
        //     Gate::define($permission->description, function(User $user) use ($permission) {
        //         return $user->hasPermission($permission->description);
        //     });
        // });

        Gate::define('owner', function (User $user, $object) {
            return $user->id === $object->user_id;
        });

        Gate::before(function (User $user) {
            if ($user->isAdmin()) return true;
        });

        //
    }
}
