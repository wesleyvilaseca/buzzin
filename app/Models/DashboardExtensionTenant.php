<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardExtensionTenant extends Model
{
    use HasFactory;
    use TenantTrait;

    protected $fillable = ['dashboard_extension_id', 'data', 'alias','status'];

    public function extension()
    {
        return $this->belongsTo(DashboardExtension::class, 'dashboard_extension_id', 'id');
    }
}
