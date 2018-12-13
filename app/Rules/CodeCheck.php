<?php

namespace App\Rules;

use DB;
use Illuminate\Contracts\Validation\Rule;

class CodeCheck implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(strlen($value) === 12 && DB::table('users')->where('identification_code', $value)->exists()) {
            return true;
        } elseif (strlen($value) === 12 && DB::table('codes')->where('code', $value)->exists()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The registration code is invalid.';
    }
}
