<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TicketsResource;
use App\Models\Ticket;
use App\Models\TicketConversation;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    private $repository;

    public function __construct(Ticket $repository)
    {
        $this->middleware(['can:support']);

        $this->repository = $repository;
    }

    public function index()
    {
        $data['title']              = 'Suporte';
        $data['toptitle']           = 'Suporte';
        $data['ticket_support']     = true;

        return view('admin.tickets.index', $data);
    }

    public function getAllSupport()
    {
        $data = $this->repository
            ->where('status', 0)
            ->orWhere('attendance_user_id', Auth::user()->id)
            ->paginate(15);

        return response()->json(TicketsResource::collection($data));
    }

    public function getAllByattendant()
    {
        $data = $this->repository
            ->where('status', 1)
            ->where('attendance_user_id', Auth::user()->id)
            ->paginate(15);

        return response()->json(TicketsResource::collection($data));
    }

    /**
     * para usar na api
     */
    public function show($id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return redirect()->back()->with('error', 'operação não autorizada');
        }

        if (!$ticket->attendance_user_id) {
            $ticket->attendance_user_id = Auth::user()->id;
            $ticket->status = 1;
            $ticket->update();
        }

        $data['title']              = 'Detalhes do ticket';
        $data['toptitle']           = 'Detalhes do ticket';
        $data['ticketid']           = $id;
        $data['ticket_support']     = true;

        return view('admin.tickets.conversation', $data);
    }

    public function getTicket($id)
    {

        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response()->json(['msg' => "not found"], 404);
        }

        $conversation = TicketConversation::where('ticket_id', $ticket->id)->get();

        $hasNoVisualizedMessage = $conversation
            ->where('user_id', "!=", Auth::user()->id)
            ->where('visualised', '=', 0)->all();

        if (sizeof($hasNoVisualizedMessage) > 0) {
            TicketConversation::where([
                ['ticket_id', '=', $ticket->id],
                ['user_id', '!=', Auth::user()->id]
            ])
                ->update(['visualised' => 1]);
        }

        return TicketResource::collection($conversation);
    }
}
