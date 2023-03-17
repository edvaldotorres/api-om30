<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\PatientController;
use App\Http\Controllers\Api\v1\ZipCodeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    return response()->json(['message' => 'Bem-vindo a API da OM30 <3']);
});

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });

    Route::middleware('jwt.api')->group(function () {
        Route::apiResource('patients', PatientController::class)->only([
            'index', 'store', 'show', 'update', 'destroy'
        ]);
        Route::get('me', [AuthController::class, 'me']);
    });
    Route::get('zipcode/{code}', [ZipCodeController::class, 'getZipCode']);
});
