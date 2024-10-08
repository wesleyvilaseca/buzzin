<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'hasIdDoc' => @isset($this->cpf) ? 'Y' : 'N',
            'doc' => cript(@$this->cpf),
            'mobile_phone' => cript(@$this->mobile_phone),
        ];
    }
}
