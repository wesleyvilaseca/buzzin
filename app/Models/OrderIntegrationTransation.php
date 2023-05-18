<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderIntegrationTransation extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'transaction_id', 'data', 'description', 'transaction_amount', 'barcode', 'payment_method_id', 'payment_type_id', 'external_resource_url', 'last_four_digits', 'status', 'status_detail'];

    public function order() {
        return $this->hasOne(Order::class, 'id', 'order_id');
    }
}

