<?php

namespace App\Helpers;

class HelperGeneral
{
    /**
     * It takes a string of numbers, removes all non-numeric characters, and then adds dots and dashes to
     * the string
     * 
     * @param string cpf The CPF number to be formatted.
     * 
     * @return string A string with the CPF formatted.
     */
    public static function formatterCpf(string $cpf): string
    {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $cpf = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9);
        return $cpf;
    }
}
