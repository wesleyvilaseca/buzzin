<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id' => $this->uuid,
            'name' => $this->name,
            'url' => $this->url,
            'icon' => $this->icon,
            'image' => $this->image ? url("storage/" . str_replace("public/", "", $this->image)) : null,
            'description' => $this->description
        ];
    }
}
