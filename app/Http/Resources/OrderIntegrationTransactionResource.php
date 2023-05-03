<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderIntegrationTransactionResource extends JsonResource
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
            'transaction_id' => $this->identify,
            'transaction_amount' => $this->transaction_amount,
            'barcode' => $this->barcode,
            'payment_method_id' => $this->payment_method_id,
            'payment_type_id' => $this->payment_method_id,
            'external_resource_url' => $this->external_resource_url,
            'status' => __('mercadopago.' . $this->status),
            'status_detail' => __('mercadopago.' . $this->status_detail, [
                'statement_descriptor' => $this->description,
                'payment_method_id' => $this->payment_method_id,
            ])
        ];
    }
}
