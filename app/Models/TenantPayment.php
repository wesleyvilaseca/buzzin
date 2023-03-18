<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantPayment extends Model
{
    use HasFactory;
    use TenantTrait;

    protected $fillable = ['payment_id', 'data', 'status'];

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id', 'payment_id');
    }
}
