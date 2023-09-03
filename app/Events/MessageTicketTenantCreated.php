<?php

namespace App\Events;

use App\Http\Resources\OrderResource;
use App\Http\Resources\TicketResource;
use App\Models\Order;
use App\Models\TicketConversation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageTicketTenantCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticketConversation;
    public $attendance_user_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(TicketConversation $ticketConversation, $attendance_user_id)
    {
        $this->ticketConversation = $ticketConversation;
        $this->attendance_user_id = $attendance_user_id;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('message-ticket-tenant-created.' . $this->attendance_user_id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['message' => (new TicketResource($this->ticketConversation))->resolve()];
    }
}
