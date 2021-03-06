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
            'time_from' => ['required_without_all:isAllDay'],
            'time_to' => ['required_without_all:isAllDay', 'after:time_from'],
            'location' => ['string', 'nullable', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'time_from.required_without_all' => 'Time field is required when it isn\'t an all day event.',
            'time_to.required_without_all' => 'Time field is required when it isn\'t an all day event.'
        ];
    }
}
