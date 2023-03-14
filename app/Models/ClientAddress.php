<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientAddress extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'address', 'zip_code', 'state', 'city', 'district', 'number', 'active', 'complement'];

    public function client()
    {
        return $this->hasOne(Client::class, 'client_id', 'id');
    }
}
