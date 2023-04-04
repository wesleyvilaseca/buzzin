<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteTenantExtensions extends Model
{
    use HasFactory;
    use TenantTrait;

    protected $fillable = ['site_extension_id', 'data', 'status'];

    public function extension()
    {
        return $this->belongsTo(SiteExtensions::class, 'site_extension_id', 'id');
    }
}
