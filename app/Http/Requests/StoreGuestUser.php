<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuestUser extends FormRequest
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
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mother_last_name' => 'string|max:255',
            'phone' => 'required|string|min:7|max:10|unique:users',
            'mobile' => 'string|min:10|max:10',
            'email' => 'string|email|max:255|unique:users',
            'password' => 'string|min:6|confirmed',
            'picture' => 'url',
            'role' => 'required|string|in:admin,user,guest',
        ];
    }
}
