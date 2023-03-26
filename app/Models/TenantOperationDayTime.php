<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\TenantTrait;

class TenantOperationDayTime extends Model
{
    use HasFactory;
    use TenantTrait;

    protected $fillable = ['tenant_operation_day_id', 'time_ini', 'time_end', 'status'];
}
