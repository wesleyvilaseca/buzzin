<?php

namespace App\Models;

use App\Models\Traits\UserACLTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use UserACLTrait;

    const IS_INTERNAL = 'Y';
    const NOT_INTERNAL = 'N';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'tenant_id',
        'last_seen'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Scope a query to only users by tenant
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTenantUser(Builder $query)
    {
        return $query->where('tenant_id', auth()->user()->tenant_id);
    }

    /**
     * Tenant
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get Roles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Roles not linked with this user
     */
    public function rolesAvailable($filter = null)
    {
        $roles = Role::whereNotIn('roles.id', function ($query) {
            $query->select('role_user.role_id');
            $query->from('role_user');
            $query->whereRaw("role_user.user_id={$this->id}");
        })
            ->where(function ($queryFilter) use ($filter) {
                if ($filter)
                    $queryFilter->where('roles.name', 'LIKE', "%{$filter}%");
            });

        if (!Auth()->user()->isAdmin()) {
            $roles->where([
                ['internal', '=', Role::NOT_INTERNAL]
            ]);
        }

        $roles = $roles->paginate();

        return $roles;
    }

    public function search($filter = null)
    {
        $results = $this->where([
            ['name', 'LIKE', "%{$filter}%"],
            ['tenant_id', '=', auth()->user()->tenant_id]
        ])
            ->orWhere([
                ['email', 'LIKE', "%{$filter}%"],
                ['tenant_id', '=', auth()->user()->tenant_id]
            ])
            ->tenantUser()->paginate();

        return $results;
    }

    public function searchAll($filter = null)
    {
        $results = $this->where([
            ['name', 'LIKE', "%{$filter}%"],
        ])
            ->orWhere([
                ['email', 'LIKE', "%{$filter}%"],
            ])
            ->paginate();
        return $results;
    }
}
