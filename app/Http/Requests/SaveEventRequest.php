<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveEventRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:100'],
            'date' => ['required', 'date'],
            'time_from' => ['required'],
            'time_to' => ['required', 'after:time_from'],
            'location' => ['string', 'nullable', 'max:255'],
        ];
    }
}
