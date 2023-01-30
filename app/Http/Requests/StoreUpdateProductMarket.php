<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateProductMarket extends FormRequest {
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
            'title' => [
                'required',
                'min:3',
                'max:255'
            ],
            'description' => ['required', 'min:3', 'max:500'],
        ];

        if ($this->method() == 'PUT') {
            $rules['image'] = ['nullable'];
        }

        return $rules;
    }
}
