<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsCountryExists implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return in_array($value, array_keys(config('country_price_diet')));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Country not found.';
    }

}
