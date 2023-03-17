<?php

namespace App\Rules\v1;

use Illuminate\Contracts\Validation\Rule;

class CnsValidation1Rule implements Rule
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

        $pis = substr($value, 0, 11);
        $soma = (intval(substr($pis, 0, 1)) * 15) +
            (intval(substr($pis, 1, 1)) * 14) +
            (intval(substr($pis, 2, 1)) * 13) +
            (intval(substr($pis, 3, 1)) * 12) +
            (intval(substr($pis, 4, 1)) * 11) +
            (intval(substr($pis, 5, 1)) * 10) +
            (intval(substr($pis, 6, 1)) * 9) +
            (intval(substr($pis, 7, 1)) * 8) +
            (intval(substr($pis, 8, 1)) * 7) +
            (intval(substr($pis, 9, 1)) * 6) +
            (intval(substr($pis, 10, 1)) * 5);
        $resto = $soma % 11;
        $dv = 11 - $resto;

        if ($dv == 11) {
            $dv = 0;
        }

        if ($dv == 10) {
            $soma = (intval(substr($pis, 0, 1)) * 15) +
                (intval(substr($pis, 1, 1)) * 14) +
                (intval(substr($pis, 2, 1)) * 13) +
                (intval(substr($pis, 3, 1)) * 12) +
                (intval(substr($pis, 4, 1)) * 11) +
                (intval(substr($pis, 5, 1)) * 10) +
                (intval(substr($pis, 6, 1)) * 9) +
                (intval(substr($pis, 7, 1)) * 8) +
                (intval(substr($pis, 8, 1)) * 7) +
                (intval(substr($pis, 9, 1)) * 6) +
                (intval(substr($pis, 10, 1)) * 5) + 2;
            $resto = $soma % 11;
            $dv = 11 - $resto;
        }

        $resultado = $pis . '000' . intval($dv);
        return $value === $resultado;
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
