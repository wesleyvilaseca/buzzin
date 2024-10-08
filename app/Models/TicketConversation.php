<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TicketConversation extends Model
{
    use HasFactory;
    const VISUALIZED = 1;
    const NOT_VIZUALIZED = 0;

    protected $fillable = ['ticket_id', 'message', 'user_id', 'created_by_tenant', 'visualized'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
