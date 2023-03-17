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

Route::prefix('v1')->group(function () {
    /* A route that returns a message when the user accesses the root of the API. */
    Route::get('/', function () {
        return response()->json(['message' => 'Bem-vindo a API da OM30 <3']);
    });
    /* Creating a route group with the prefix `auth` and then creating two routes inside of it. */
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
    });
    /* This is a route group that uses the `jwt.api` middleware. This middleware is responsible for
    verifying the token sent by the user. If the token is valid, the user will be able to access the
    routes inside the group. */
    Route::middleware('jwt.api')->group(function () {
        Route::apiResource('patients', PatientController::class)->only([
            'index', 'store', 'show', 'update', 'destroy'
        ]);
        Route::get('me', [AuthController::class, 'me']);
    });
    /* This route is used to get the zip code information from the ViaCep API. */
    Route::get('zipcode/{code}', [ZipCodeController::class, 'getZipCode']);
});
