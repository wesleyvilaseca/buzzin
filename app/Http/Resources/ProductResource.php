<?php

namespace App\Http\Resources;

use App\Models\StatusProductNoStock;
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
            'image' => $this->image ? getFileLink($this->image) : null,
            'stock_controll' => $this->stock_controll,
            'condition_sell' => StatusProductNoStock::find($this->status_product_no_stock_id ?? 1)->description,
            'has_stock' => $this->quantity > 0 ? true : false,
            'price' => $this->price,
            'description' => $this->description,
        ];
    }
}
