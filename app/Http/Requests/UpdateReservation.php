<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReservation extends FormRequest
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
            'dog_id' => 'numeric',
            'start_date' => 'date_format:Y-m-d H:i',
            'end_date' => 'date_format:Y-m-d H:i|after:start_date',
            'status_id' => 'numeric',
            'services' => 'array'
        ];
    }
}
