<?php

namespace App\Services;

use App\Mail\TicketNotify;
use App\Models\TicketConversation;
use App\Models\User;
use App\Models\UserNotify;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NotifyService
{

    public function __construct()
    {
    }

    public function ticketNotifyVisualized()
    {
        UserNotify::where([
            'user_id' => Auth::user()->id,
            'type' => UserNotify::TICKET_TYPE,
            'visualized' => UserNotify::NOT_VISUALIZED
        ])
            ->update(['visualized' => UserNotify::VISUALIZED]);
    }

    public function ticketNofify(TicketConversation $ticketConversation, $user_id)
    {
        $hasNotifyNotVisualized = UserNotify::where([
            'user_id' => $user_id,
            'type' => UserNotify::TICKET_TYPE,
            'visualized' => UserNotify::NOT_VISUALIZED
        ])
            ->first();

        if ($hasNotifyNotVisualized) {
            return;
        }

        DB::beginTransaction();
        try {
            $user = User::find($user_id);
            UserNotify::create([
                'user_id' => $user->id,
                'tenant_id' => $ticketConversation->ticket->tenant_id,
                'message' => $ticketConversation->message,
                'type' => UserNotify::TICKET_TYPE,
                'visualized' => UserNotify::NOT_VISUALIZED
            ]);
            Mail::to($user->email)->send(new TicketNotify($ticketConversation, $user));
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            // throw new Exception('Falha no envio da notificação. Erro: ' . $e->getMessage());
        }
    }
}
