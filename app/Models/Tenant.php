<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'cnpj', 'plan_id', 'name', 'uid', 'url', 'email', 'logo',
        'address', 'zip_code', 'state', 'city', 'district', 'number',
        'active', 'subscription', 'expires_at', 'subscription_id', 'subscription_active', 'subscription_suspended',
        'order_when_close', 'open'
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function site()
    {
        return $this->hasMany(Site::class, 'tenant_id', 'id');
    }

    public function tenantShipping() {
        return $this->hasMany(TenantShipping::class, 'tenant_id', 'id');
    }
}
