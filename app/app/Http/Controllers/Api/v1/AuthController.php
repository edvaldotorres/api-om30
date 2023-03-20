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
     * It attempts to authenticate the user using the email and password provided in the request, and if it
     * succeeds, it returns a new AuthResource instance with the user and the token
     * 
     * @param AuthRequest request The request object.
     * 
     * @return A new AuthResource instance.
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
     * > It creates a new user, logs them in, and returns a resource with the user and their token
     * 
     * @param AuthRequest request The request object.
     * 
     * @return A new AuthResource with the user and token.
     */
    public function register(AuthRequest $request)
    {
        $user = User::create($request->validated());
        $token = auth('api')->login($user);

        return new AuthResource($user, $token);
    }
}
