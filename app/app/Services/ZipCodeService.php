<?php

namespace App\Services;

use App\Exceptions\InvalidZipCodeException;
use Exception;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class ZipCodeService
{
    public function fetchZipCodeData(string $code)
    {
        $validator = Validator::make(['zipcode' => $code], [
            'zipcode' => 'required|size:8|regex:/^[0-9]+$/',
        ]);

        if ($validator->fails()) {
            throw new InvalidZipCodeException();
        }

        $response = Redis::get($code);
        if ($response !== null) {
            echo 1;
            return json_decode($response);
        }

        echo 2;

        $url = 'https://viacep.com.br/ws/' . $code . '/json';

        $response = file_get_contents($url);

        if ($response === false) {
            throw new Exception('Error fetching zip code data');
        }

        Redis::setex($code, 20, $response);

        return json_decode($response);
    }
}
