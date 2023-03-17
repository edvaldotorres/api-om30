<?php

namespace App\Rules\v1;

use Illuminate\Contracts\Validation\Rule;

class CnsValidation2Rule implements Rule
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
        if (strlen($value) !== 15) {
            return false;
        }

        $soma = (intval($value[0]) * 15) +
            (intval($value[1]) * 14) +
            (intval($value[2]) * 13) +
            (intval($value[3]) * 12) +
            (intval($value[4]) * 11) +
            (intval($value[5]) * 10) +
            (intval($value[6]) * 9) +
            (intval($value[7]) * 8) +
            (intval($value[8]) * 7) +
            (intval($value[9]) * 6) +
            (intval($value[10]) * 5) +
            (intval($value[11]) * 4) +
            (intval($value[12]) * 3) +
            (intval($value[13]) * 2) +
            (intval($value[14]) * 1);

        $resto = $soma % 11;

        if ($resto !== 0) {
            return false;
        }

        if (!in_array($value[0], ['7', '8', '9'])) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute number is invalid.';
    }
}
