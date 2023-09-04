<?php

namespace App\Http\Controllers\Web\Admin;

use App\Events\MessageTicketTenantCreated;
use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Http\Resources\TicketsResource;
use App\Models\TenantSites;
use App\Models\Ticket;
use App\Models\TicketConversation;
use Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class TenantTicketsController extends Controller
{
    private $repository;

    public function __construct(Ticket $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $data['title']              = 'Suporte';
        $data['toptitle']           = 'Suporte';

        return view('admin.tenant-tickets.index', $data);
    }

    public function getAll()
    {
        $data = $this->repository->where('tenant_id', Auth::user()->tenant_id)->latest()->get();
        return response()->json(TicketsResource::collection($data));
    }

    public function getAllByTenant()
    {
        $data = $this->repository
            ->where([
                'tenant_id' => Auth::user()->tenant_id
            ])
            ->latest()
            ->paginate(15);

        return response()->json(TicketsResource::collection($data));
    }

    public function store(Request $request)
    {

        $validate = Validator::make($request->all(), [
            "ticket_type_id" => ['required'],
            "description" => ['required'],
            "message" => ['required']
        ]);

        if ($validate->fails()) {
            return Redirect::route('admin.site')->with("errors", $validate->errors());
        }

        DB::beginTransaction();
        try {
            $res = $this->repository->create([
                'tenant_id' =>  Auth::user()->tenant_id,
                'ticket_type_id' => $request->ticket_type_id,
                'description' => $request->description,
                'status' => 0
            ]);

            TicketConversation::create([
                'ticket_id' => $res->id,
                'message' => $request->message,
                'user_id' => Auth::user()->id,
                'created_by_tenant' => 1,
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Houve um erro na requisição, tente novamento', 'detail' => $e->getMessage()], 400);
        }
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

        $data['title']              = 'Detalhes do ticket';
        $data['toptitle']           = 'Detalhes do ticket';
        $data['ticketid']           = $id;
        $data['breadcrumb'][]       = ['route' => route('admin.tenant.tickets'), 'title' => 'Meus tickets'];
        $data['breadcrumb'][]       = ['route' => '#', 'title' => 'Ticket', 'active' => true];

        return view('admin.tenant-tickets.conversation', $data);
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

    public function closeTicket(Request $request, $id) {
        $ticket = Ticket::find($id);
        if (!$ticket) {
            return response()->json(['msg' => "not found"], 404);
        }

        $ticket->status = Ticket::STATUS_CLOSE_BY_TENANT;
        $res = $ticket->update();

        if(! $res) {
            return response()->json(['error' => 'erro na operação', 402]);
        }

        $lastConverSation = TicketConversation::where('ticket_id', $ticket->id)->latest()->first();
        $lastConverSation->message = 'Ticket encessado pelo cliente';
        
        broadcast(new MessageTicketTenantCreated($lastConverSation, $request->attendance_user_id));

        return response()->json($res);
    }

    public function sendMessage(Request $request)
    {

        $validate = Validator::make($request->all(), [
            'ticket_id' => ['required'],
            'message' => ['required'],
            'attendance_user_id' => ['required']
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
                'created_by_tenant' => 1,
                'user_id' => Auth::user()->id
            ]);

            broadcast(new MessageTicketTenantCreated($conversation, $request->attendance_user_id));
            DB::commit();
            return new TicketResource($conversation);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Houve um erro na requisição, tente novamento', 'detail' => $e->getMessage()], 404);
        }
    }
}
