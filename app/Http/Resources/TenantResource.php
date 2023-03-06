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
            'domain' => @$this->site[0]?->domain,
            'subdomain' => @$this->site[0]?->subdomain,
            'logo' => $this->logo ? url("storage/" . str_replace("public/", "", $this->logo)) : null,
            'date_created' => Carbon::parse($this->created_at)->format('d/m/Y')
        ];
    }
}
