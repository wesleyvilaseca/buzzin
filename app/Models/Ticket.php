<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    const STATUS_OPEN = 1;
    const STATUS_ATTENDANCE = 2;
    const STATUS_CLOSE_BY_TENANT = 3;
    const STATUS_CLOSE_BY_SUPPORT = 4;
    const STATUS_AUTOMATIC_CLOSE = 5;

    protected $fillable = ['ticket_type_id', 'tenant_id', 'description', 'status', 'attendance_user_id'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
    }

    public function attendant()
    {
        return $this->belongsTo(User::class, 'attendance_user_id', 'id');
    }

    public function conversation() 
    {
        return $this->hasMany(TicketConversation::class, 'ticket_id', 'id');
    }
}
