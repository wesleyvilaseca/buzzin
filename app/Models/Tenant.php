<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'cnpj', 'name', 'uid' ,'url', 'email', 'logo', 
        'address', 'zip_code', 'state', 'city', 'district', 'number',
        'active','subscription', 'expires_at', 'subscription_id', 'subscription_active', 'subscription_suspended',
    ];


    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
