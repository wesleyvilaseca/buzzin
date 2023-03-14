<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientAddressResource extends JsonResource
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
            'address' => $this->address,
            'zip_code' => $this->zip_code,
            'state' => $this->state,
            'city' => $this->city,
            'district' => $this->district,
            'number' => $this->number,
            'complement' => $this->complement,
            'status' => $this->status
        ];
    }
}
