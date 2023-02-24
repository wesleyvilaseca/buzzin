<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use TenantTrait;
    use HasFactory;

    protected $fillable = ['domain', 'subdomain', 'data', 'maintence', 'status'];
}
