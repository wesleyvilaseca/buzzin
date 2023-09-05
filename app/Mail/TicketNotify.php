<?php

namespace App\Mail;

use App\Models\Ticket;
use App\Models\TicketConversation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketNotify extends Mailable
{
    use Queueable, SerializesModels;
    private $ticketConversation;
    private $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(TicketConversation $ticketConversation, User $user)
    {
        $this->ticketConversation = $ticketConversation;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['ticketConversation'] = $this->ticketConversation;
        $data['user'] = $this->user;
        return $this->view('mail.ticket_notify', $data);
    }
}
