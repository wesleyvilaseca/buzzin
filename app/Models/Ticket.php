<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_type_id', 'tenant_id', 'description', 'status', 'attendance_user_id'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }

    public function attendant()
    {
        return $this->belongsTo(User::class, 'attendance_user_id', 'id');
    }
}
