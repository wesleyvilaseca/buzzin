<?php

namespace App\Http\Resources;

use App\Models\StatusProductNoStock;
use Illuminate\Http\Resources\Json\JsonResource;

class TenantSiteExtensionsResource extends JsonResource
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
            'tag' => $this->extension->tag,
            'title' => $this->extension->description,
            'data' => $this->data
        ];
    }
}
