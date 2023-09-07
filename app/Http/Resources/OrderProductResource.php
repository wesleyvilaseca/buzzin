<?php

namespace App\Http\Resources;

use App\Models\StatusProductNoStock;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource
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
            'identify' => $this->product->uuid,
            'flag' => $this->product->flag,
            'title' => $this->product->title,
            'image' => $this->product->image ? getFileLink($this->product->image) : null,
            'has_stock' => $this->product->quantity > 0 ? true : false,
            'price' => $this->price,
            'description' => $this->product->description,
            'qty' => $this->qty,
        ];
    }
}
