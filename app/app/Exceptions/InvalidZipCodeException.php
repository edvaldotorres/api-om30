<?php

namespace App\Exceptions;

use Exception;

/* This class is an exception that is thrown when a zip code is invalid. */
class InvalidZipCodeException extends Exception
{
    protected $message = 'Invalid zip code';
}