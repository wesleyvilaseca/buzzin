<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketConversation extends Model
{
    use HasFactory;
    protected $fillable = ['ticket_id', 'message', 'sender_user_id', 'created_by_tenant', 'visualized'];
}
