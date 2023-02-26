<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = "payments";

    public function tenantHasPayment()
    {
        return $this->hasMany(TenantPayment::class, 'id', 'payment_id');
    }
}
