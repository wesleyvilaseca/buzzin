<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasFactory;
    use HasApiTokens;

    protected $fillable = [
        'name', 'email', 'password', 'tenant_id',
    ];


    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
