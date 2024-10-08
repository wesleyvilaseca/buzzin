<?php

namespace App\Models\Traits;

use App\Models\Tenant;
use App\Models\User;

trait UserACLTrait
{
    public function permissions(): array
    {
        $permissionsPlan = $this->permissionsPlan();
        $permissionsRole = $this->permissionsRole();

        $permissions = [];
        foreach ($permissionsRole as $permission) {
            if (in_array($permission, $permissionsPlan)) array_push($permissions, $permission);
        }

        return $permissions;
    }

    public function permissionsPlan(): array
    {
        // $tenant = $this->tenant;
        // $plan = $tenant->plan;
        $tenant = Tenant::with('plan.profiles.permissions')->where('id', $this->tenant_id)->first();
        $plan = $tenant->plan;

        $permissions = [];
        foreach ($plan->profiles as $profile) {
            foreach ($profile->permissions as $permission) {
                array_push($permissions, $permission->description);
            }
        }

        return $permissions;
    }

    public function permissionsRole(): array
    {
        $roles = $this->roles()->with('permissions')->get();

        $permissions = [];
        foreach ($roles as $role) {
            foreach ($role->permissions as $permission) {
                array_push($permissions, $permission->description);
            }
        }

        return $permissions;
    }

    public function hasPermission(string $permissionName): bool
    {
        if($this->internal == User::NOT_INTERNAL) {
            return in_array($permissionName, $this->permissions());
        }

        return in_array($permissionName, $this->permissionsRole());
    }

    public function isAdmin(): bool
    {
        if($this->super_admin == 'Y'){
            return true;
        }

        return false;      
    }

    public function isTenant(): bool
    {
        return !in_array($this->email, config('acl.admins'));
    }
}
