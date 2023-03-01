<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantShipping extends Model
{
    use HasFactory;
    use TenantTrait;

    protected $fillable = ['shipping_id', 'data', 'status'];
}
