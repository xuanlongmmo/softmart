<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class validatenew extends FormRequest
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
            'title' => 'required|min:15|max:100',
            'linkimage' => 'required|min:15|max:100',
            'content' => 'required|min:500|max:10000'
        ];
    }
}
