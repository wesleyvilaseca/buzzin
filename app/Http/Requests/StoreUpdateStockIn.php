<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateStockIn extends FormRequest {
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

        $rules = [
            'product_market_id' => ['integer', 'required'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'numeric'],
            'anotation' => ['max:255']
        ];

        return $rules;
    }
}
