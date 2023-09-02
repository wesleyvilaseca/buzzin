<?php

namespace App\Http\Resources;

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
            'attendant' => $this->attendance_user_id ? $this->attendant->name : '',
            'created_at' => Carbon::make($this->created_at)->format('d/m/Y'),
            'updated_at' => Carbon::make($this->updated_at)->format('d/m/Y')   
        ];
    }
}
