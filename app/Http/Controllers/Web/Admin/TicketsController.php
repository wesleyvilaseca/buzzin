<?php

namespace App\Http\Controllers\Web\Admin;

use App\Events\MessageTicketSupportCreated;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TicketsResource;
use App\Models\Ticket;
use App\Models\TicketConversation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
            ->latest()
            ->paginate(15);

        return response()->json(TicketsResource::collection($data));
    }

    public function getAllByattendant()
    {
        $data = $this->repository
            ->where('status', 1)
            ->where('attendance_user_id', Auth::user()->id)
            ->latest()
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
        $data['ticket']           = $ticket;
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

    public function closeTicket(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response()->json(['msg' => "not found"], 404);
        }

        $ticket->status = Ticket::STATUS_CLOSE_BY_SUPPORT;
        $res = $ticket->update();

        if (!$res) {
            return response()->json(['error' => 'erro na operação', 402]);
        }

        $lastConverSation = TicketConversation::where('ticket_id', $ticket->id)->latest()->first();
        $lastConverSation->message = 'Ticket encessado pelo atendente';

        broadcast(new MessageTicketSupportCreated($lastConverSation, $request->attendance_user_id));

        return response()->json($res);
    }

    public function sendMessage(Request $request, $id)
    {

        $validate = Validator::make($request->all(), [
            'ticket_id' => ['required'],
            'message' => ['required'],
            'tenant_user_id' => ['required']
        ]);

        if ($validate->fails()) {
            return response()->json((object) ["errors" => $validate->errors()], 400);
        }

        DB::beginTransaction();
        try {
            $ticket = Ticket::find($request->ticket_id);
            if (!$ticket) {
                return response()->json(['msg' => "not found"], 404);
            }

            $conversation = TicketConversation::create([
                'ticket_id' => $request->ticket_id,
                'message' => $request->message,
                'created_by_tenant' => 0,
                'user_id' => Auth::user()->id
            ]);

            broadcast(new MessageTicketSupportCreated($conversation, $request->tenant_user_id));
            DB::commit();
            return new TicketResource($conversation);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Houve um erro na requisição, tente novamento', 'detail' => $e->getMessage()], 404);
        }
    }
}
