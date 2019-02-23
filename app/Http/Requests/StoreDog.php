<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StoreDog extends FormRequest
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
     * @param Request $request
     * @return array
     */
    public function rules(Request $request)
    {
        return [
            'name' => 'bail|required|string|min:3|max:100',
            'breed_id' => 'bail|required|numeric',
            'gender' => 'bail|required|boolean',
            'picture' => 'url',
            'dob' => 'required|date_format:Y-m-d',
            'color_id' => 'bail|required|numeric',
            'spots_color_id' => 'numeric',
            'size_id' => 'bail|required|numeric',
            'sterialized' => 'required|boolean',
            'lunch_time' => 'bail|required|date_format:H:i',
            'friendly' => 'bail|required|boolean',
            'observations' => 'bail|string|min:5|max:255',
            'user_id' => Rule::requiredIf($request->user()->hasRole('admin')),
        ];
    }
}
