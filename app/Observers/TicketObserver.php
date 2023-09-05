<?php

namespace App\Observers;

use App\Models\Ticket;
use Illuminate\Support\Str;


class TicketObserver
{
    /**
     * Handle the Ticket "creating" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function creating(Ticket $ticket)
    {
        $ticket->uuid = Str::uuid();
    }

    /**
     * Handle the Ticket "updating" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function updating(Ticket $ticket)
    {
       
    }

    /**
     * Handle the Ticket "deleted" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function deleted(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function restored(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function forceDeleted(Ticket $ticket)
    {
        //
    }
}
