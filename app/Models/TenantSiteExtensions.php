<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantSiteExtensions extends Model
{
    use HasFactory;

    protected $table = 'site_tenant_extensions';

    public function extension()
    {
        return $this->belongsTo(SiteExtensions::class, 'site_extension_id', 'id');
    }
}
