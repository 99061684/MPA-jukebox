<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ColorPattern implements Rule
{
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
        if($value !== null && preg_match('/#([[:xdigit:]]{3}){1,2}\b/', $value)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Not a valid color pattern, :attribute.';
    }
}
