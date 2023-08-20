<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    const ALIAS_GET_ON_STORE = 'getonstore';
    const ALIAS_MAKE_DELIVERY = 'delivery';
}
