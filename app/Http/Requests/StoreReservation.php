<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //return $this->user()->hasRole('normal') || $this->user()->hasRole('admin');
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
            'dog_id' => 'bail|required|numeric',
            'start_date' => 'bail|required|date_format:Y-m-d H:i',
            'end_date' => 'bail|required|date_format:Y-m-d H:i|after:start_date',
            'services' => 'bail|required|array'
        ];
    }
}
