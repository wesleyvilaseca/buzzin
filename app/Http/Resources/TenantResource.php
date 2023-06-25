<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TenantResource extends JsonResource
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
            'uuid' => $this->uuid,
            'flag' => $this->url,
            'contact' => $this->email,
            'domain' => @$this->site->domain,
            'subdomain' => @$this->site->subdomain,
            'address' => $this->address,
            'zip_code' => $this->zip_code,
            'state' => $this->state,
            'district' => $this->district,
            'city' => $this->city,
            'number' => $this->number,
            'email' => $this->email,
            'logo' => $this->logo ? getImage($this->logo) : null,
            'site_data' => json_decode($this->site->data),
            'date_created' => Carbon::parse($this->created_at)->format('d/m/Y'),
            'isOpen' => $this->isOpen(),
            'orderWhenClose' => $this->order_when_closed ? 'Y' : 'N',
            'clientCanBuy' => $this->clientCanBay(),
            'operationDays' => $this->getGetOperationDays(),
            'social' => $this->getSocial(),
            'about_us' => $this->getAboutUs()
        ];
    }
}
