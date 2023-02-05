<?php

namespace App\Http\Requests;

use App\Tenant\Rules\UniqueTenant;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateZones extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $id = $this->segment(3);

        return [
            'name'  => ['required', 'string', 'max:255', "unique:zones,name,{$this->id}"],
            'coordinates' => ['required'],
            'delivery_time_ini' => ['required', 'numeric'],
            'delivery_time_end' => ['required', 'numeric'],
            'time_type' => ['required', 'numeric'],
            'active' => ['required', 'numeric'],
            'type' => ['required', 'numeric'],
            'free' => ['required', 'numeric'],
        ];
    }
}
