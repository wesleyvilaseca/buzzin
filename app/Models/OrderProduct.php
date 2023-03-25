<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'product_id', 'qty', 'price'];

    protected $table = "order_product";

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
