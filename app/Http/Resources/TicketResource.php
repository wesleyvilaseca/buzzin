<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'description' => $this->ticket->description,
            'ticket_id' => $this->ticket_id,
            'message' => $this->message,
            'visualized' => $this->description,
            'created_by_tenant' => $this->created_by_tenant,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
            'created_at' => Carbon::make($this->created_at)->format('Y-m-d h:i:s')
        ];
    }
}
