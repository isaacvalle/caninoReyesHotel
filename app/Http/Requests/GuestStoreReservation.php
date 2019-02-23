<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestStoreReservation extends FormRequest
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
            'dog_name' => 'bail|required|string|min:3|max:30',
            'dog_breed' => 'bail|required|string|min:3|max:30',
            'dog_size' => 'bail|required|string|min:1|max:1',
            'user_name' => 'bail|required|string|min:4|max:25',
            'user_last_name' => 'bail|required|string|min:4|max:25',
            'phone' => 'bail|required|string|min:7|max:10',
            'start_date' => 'bail|required|date_format:Y-m-d H:i',
            'end_date' => 'bail|required|date_format:Y-m-d H:i|after:start_date',
            'services' => 'bail|required|array'
        ];
    }
}
