<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantOperationDay extends Model
{
    use TenantTrait;
    use HasFactory;

    protected $fillable = ['operation_day_id', 'data', 'status'];

    public function operationDay()
    {
        return $this->hasOne(OperationDay::class, 'operation_day_id', 'id');
    }
}
