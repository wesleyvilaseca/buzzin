<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientProductMarket extends Model {
    use HasFactory;
    protected $fillable = ['product_market_id', 'quantity', 'client_id'];

    public function product() {
        return $this->hasOne(ProductMarket::class, 'id', 'product_market_id');
    }
}
