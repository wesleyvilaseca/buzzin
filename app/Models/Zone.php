<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;
    use TenantTrait;

    protected $fillable = ['name', 'coordinates', 'delivery_time_ini', 'delivery_time_end', 'active', 'type', 'free', 'free_when', 'time_type'];
}
