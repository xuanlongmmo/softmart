<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createsubadmin extends FormRequest
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
            'fullname' => 'required|min:3|max:50',
            'phone' => 'numeric|regex:/(0)[0-9]{9}/',
            'address' => 'required|min:5|max:100',
            'email' => 'required|min:5|max:100|unique:users,email',
            'username' => 'required|min:5|max:100|unique:users,username',
            'password' => 'required|min:6|max:100',
            'repassword' => 'required|same:password'
        ];
    }
}
