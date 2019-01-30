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
        return [
            'keywords' => ['nullable', 'string', 'max:255'],
            'from_year' => ['nullable', 'numeric', 'between:2015,2029', 'required_with:from_month'],
            'from_month' => ['nullable', 'numeric', 'between:1,12',],
            'to_year' => ['nullable', 'numeric', 'between:2015,2029', 'required_with:to_month'],
            'to_month' => ['nullable', 'numeric', 'between:1,12'],
            'author' => ['nullable', 'string', 'max:100'],
            'category_id' => ['exists:categories,id'],
            'tag_ids.*' => ['exists:tags,id'],
        ];
    }
}
