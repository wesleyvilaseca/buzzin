<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantSites extends Model
{
    use HasFactory;

    protected $table = 'sites';
    protected $fillable = ['domain', 'subdomain', 'data', 'maintence', 'status'];

    public function tenant()
    {
        return $this->hasOne(Tenant::class, 'id', 'tenant_id');
    }
}
