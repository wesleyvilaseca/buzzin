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
    protected $whatssappNewOrderNotifyService;
    protected $orderService;

    public function __construct(
        OrderService $orderService,
        WhatssappNewOrderNotifyService $whatssappNewOrderNotifyService
    ) {
        $this->orderService = $orderService;
        $this->whatssappNewOrderNotifyService = $whatssappNewOrderNotifyService;
    }

    public function notifyNewOrder(object $order)
    {
        $this->whatssappNewOrderNotifyService->newOrderNotify($order);
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
            'vizualized' => UserNotify::NOT_VISUALIZED
        ])
        ->first();

        if($hasNotifyNotVisualized) {
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
