<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotify extends Model
{
    use HasFactory;

    const TICKET_TYPE = 1;
    const NEW_SALE_TYPE = 2;
    const VISUALIZED = 1;
    const NOT_VISUALIZED = 0;

    protected $fillable = ['user_id', 'tenant_id','message', 'data', 'type', 'visualized'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
