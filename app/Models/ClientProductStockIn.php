<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProductStockIn extends Model {
    use HasFactory;
    protected $fillable = ['nota', 'product_market_id', 'price', 'quantity', 'client_id'];

    public function product() {
        return $this->hasOne(ProductMarket::class, 'id', 'product_market_id');
    }
}
