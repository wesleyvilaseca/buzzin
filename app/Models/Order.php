<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['tenant_id', 'identify', 'client_id', 'table_id', 'total', 'status', 'comment', 'data'];

    /**
     * Options status
     */
    public $statusOptions = [
        'open' => 'Aberto',
        'done' => 'Completo',
        'rejected' => 'Rejeitado',
        'working' => 'Andamento',
        'canceled' => 'Cancelado',
        'delivering' => 'Em transito',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function order_products()
    {
        return $this->hasMany(OrderProduct::class, 'order_id', 'id');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function addressClientOrder() {
        $data = json_decode($this->data);
        return $data->client_address;
    }

    public function paymentMethodOrder() {
        $data = json_decode($this->data);
        return $data->payment_method;
    }

    public function shippingMethodOrder() {
        $data = json_decode($this->data);
        return $data->shipping_method;
    }
}
