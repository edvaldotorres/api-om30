<?php

namespace Tests;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

     /**
     * Set the currently logged in user for the application.
     *
     * @param Authenticatable $user
     * @param string|null $guard
     * @return $this
     */
    public function actingAs(UserContract $user, $guard = null)
    {
        $token = JWTAuth::fromUser($user);
        $this->withHeader('Authorization', "Bearer $token");
        parent::actingAs($user, $guard);

        return $this;
    }
}
