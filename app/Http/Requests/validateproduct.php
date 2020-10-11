<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class validateproduct extends FormRequest
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
            'nameproduct' => 'required|min:3|max:100',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'price' => 'required|numeric|between:0,1000000000',
            'quantity' => 'required|numeric|between:0,10000',
            'description' => 'required',
            'feesale' => 'required|numeric|between:0,100'
        ];
    }
}
