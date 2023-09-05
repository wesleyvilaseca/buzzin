<?php

namespace App\Http\Resources;

use App\Models\TicketConversation;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'ticket_type_id' => $this->ticket_type_id,
            'status' => $this->status,
            'description' => $this->description,
            'not_visualized_message' => $this->conversation
                ->where('visualized', '=', TicketConversation::NOT_VIZUALIZED)
                ->where('user_id', '=', $this->attendance_user_id)
                ->count(),
            'attendant' => $this->attendance_user_id ? $this->attendant->name : '',
            'created_at' => Carbon::make($this->created_at)->format('d/m/Y'),
            'updated_at' => Carbon::make($this->updated_at)->format('d/m/Y')
        ];
    }
}
