<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderClientResource extends JsonResource
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
            'identify' => $this->identify,
            'total' => $this->total,
            'status' => $this->status,
            'status_label' => $this->statusOptions[$this->status],
            'date' => Carbon::make($this->created_at)->format('Y-m-d'),
            'date_br' => Carbon::make($this->created_at)->format('d/m/Y'),
            'company' => new TenantResource($this->tenant),
            'client' => $this->client_id ? new ClientResource($this->client) : '',
            'table' => $this->table_id ? new TableResource($this->table) : '',
            'products' => OrderProductResource::collection($this->order_products),
            'evaluations' => EvaluationResource::collection($this->evaluations),
            'payment_method' => $this->paymentMethodOrder(),
            'shipping_method' =>  $this->shippingMethodOrder(),
            'client_address' => $this->addressClientOrder()
        ];
    }
}
