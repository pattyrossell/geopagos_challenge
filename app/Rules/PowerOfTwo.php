<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PowerOfTwo implements Rule
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
        return is_numeric($value) && ($value > 0) && (($value & ($value - 1)) == 0);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a power of 2.';
    }
}
