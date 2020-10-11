<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class validatebranch extends FormRequest
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
            'name' => 'required',
            'hotline' => 'required',
            'email' => 'required',
            'facebook' => 'required',
            'instagram' => 'required',
            'twitter' => 'required',
            'address' => 'required',
            'phone' => 'required',
            // 'about' => 'required',
            // 'account_number' => 'required',
            // 'bank_name' => 'required',
            // 'company_name' => 'required'
        ];
    }
}
