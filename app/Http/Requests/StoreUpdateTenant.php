<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateTenant extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cnpj' => ['required', 'string', 'max:20'],
            'name'  => ['required', 'string', 'max:255'],
            // 'tenant_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            // 'address' => ['required', 'string', 'max:255'],
            // 'zip_code' => ['required', 'string', 'max:10'],
            // 'state' => ['required', 'string', 'max:10'],
            // 'city' => ['required', 'string', 'max:45'],
            // 'district' => ['required', 'string', 'max:45'],
            // 'password' => ['required', 'string', 'min:8']
        ];
    }
}
