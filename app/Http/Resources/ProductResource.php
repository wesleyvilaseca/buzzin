<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'identify' => $this->uuid,
            'flag' => $this->flag,
            'title' => $this->title,
            // 'image' => url("storage/{$this->image}"),
            'image' => $this->image ? url("storage/" . str_replace("public/", "", $this->image)) : null,
            'price' => $this->price,
            'description' => $this->description,
        ];
    }
}
