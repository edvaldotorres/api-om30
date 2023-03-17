<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\AuthRequest;
use App\Http\Resources\v1\AuthResource;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(AuthRequest $request)
    {
        $token = auth('api')->attempt($request->only('email', 'password'));
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return new AuthResource(auth('api')->user(), $token);
    }

    /**
     * Get the authenticated User.
     *
    //  * @return \Illuminate\Http\JsonResponse
     */
    public function register(AuthRequest $request)
    {
        $user = User::create($request->validated());
        $token = auth('api')->login($user);

        return new AuthResource($user, $token);
    }

    /**
     * Display the specified resource.
     *
    //  * @return \Illuminate\Http\Response
     */
    public function me()
    {
        //
    }
}
