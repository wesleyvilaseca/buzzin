<?php

namespace App\Models;

use App\Tenant\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantPayment extends Model
{
    use HasFactory;
    use TenantTrait;

    protected $fillable = ['payment_id', 'data', 'alias','status'];

    public function payment()
    {
        return $this->hasOne(Payment::class, 'id', 'payment_id');
    }

    public function getDataPaymentIntegration()
    {
        $data = json_decode($this->data);
        unset($data->access_token);
        return json_encode($data);
    }
}
