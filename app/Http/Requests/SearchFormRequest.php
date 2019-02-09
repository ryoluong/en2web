<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchFormRequest extends FormRequest
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
        $custom_validator = function ($attribute, $value, $fail) {
            $input_data = $this->all();
            if(!empty($input_data['from_year'])) {
                if($input_data['from_year'] > $input_data['to_year'] or $input_data['from_year'] = $input_data['to_year'] && $input_data['from_month'] > $input_data['to_month']) {
                    $fail('Selected data is invalid.');
                }
            }
        };
        return [
            'keywords' => ['nullable', 'string', 'max:255'],
            'from_year' => ['nullable', 'numeric', 'between:2015,2029', 'required_with:from_month'],
            'from_month' => ['nullable', 'numeric', 'between:1,12',],
            'to_year' => ['nullable', 'numeric', 'between:2015,2029', 'required_with:to_month', $custom_validator],
            'to_month' => ['nullable', 'numeric', 'between:1,12'],
            'author' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'category_id' => ['exists:categories,id'],
            'tag_ids.*' => ['exists:tags,id'],
            'validator' => ['required_without_all:keywords,from_year,to_year,author,country,category_id,tag_ids']
        ];
    }
}
