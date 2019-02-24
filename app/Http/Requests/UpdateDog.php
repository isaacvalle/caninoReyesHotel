<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateDog extends FormRequest
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
            'name' => 'bail|string|min:3|max:100',
            'breed_id' => 'bail|numeric|exits:breeds,id',
            'gender' => 'boolean',
            'picture' => 'url',
            'dob' => 'date_format:Y-m-d',
            'color_id' => 'numeric|exists:colors,id',
            'spots_color_id' => 'numeric|exists:colors,id',
            'size_id' => 'numeric|exists:size_categories,id',
            'sterialized' => 'boolean',
            'lunch_time' => 'date_format:H:i',
            'friendly' => 'boolean',
            'observations' => 'string|min:5|max:255'
        ];
    }
}
