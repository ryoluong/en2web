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
            'from_year' => ['between:2015,2029'],
            'from_month' => ['between:1,12'],
            'to_year' => ['between:2015,2029'],
            'to_month' => ['between:1,12'],
            'author' => ['string', 'max:100'],
            'category_id' => ['exists:categories,id'],
            'tag_ids.*' => ['exists:tags,id'],
        ];
    }
}
