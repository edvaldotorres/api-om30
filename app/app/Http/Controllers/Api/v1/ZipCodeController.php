<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ZipCodeController extends Controller
{
    private $baseUrlApiViaCep = 'https://viacep.com.br/ws/';

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $zipCode = $request->query('code');

        if (!preg_match('/^[0-9]{8}$/', $zipCode)) {
            return response()->json([
                'message' => 'Cep inválido',
            ], 400);
        }

        $response = Redis::get($zipCode);
        if ($response !== null) {
            echo 'redis';
            return response()->json(json_decode($response));
        }

        echo 'api';

        $url = $this->baseUrlApiViaCep . $zipCode . '/json';

        $response = file_get_contents($url);

        if ($response === false) {
            return response()->json([
                'message' => 'Erro ao buscar cep',
            ], 500);
        }

        Redis::setex($zipCode, 3600, $response);

        return response()->json(json_decode($response));
    }
}
