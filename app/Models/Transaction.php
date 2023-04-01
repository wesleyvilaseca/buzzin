<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\TenantTrait;

class Transaction extends Model
{
    use HasFactory;
    use TenantTrait;

    protected $fillable = ['transaction_id', 'data', 'description', 'transaction_amount', 
    'barcode', 'payment_method_id', 'payment_type_id', 'external_resource_url', 'total',
    'last_four_digits', 'status', 'status_detail', 'type_transaction'];

}
