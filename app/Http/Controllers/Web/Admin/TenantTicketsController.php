<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
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
        $data = $this->repository->where('tenant_id', Auth::user()->tenant_id)->get();
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
                'sender_user_id' => Auth::user()->id,
                'created_by_tenant' => 1,
            ]);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Houve um erro na requisição, tente novamento', 'detail' => $e->getMessage()], 400);
        }
    }
}
