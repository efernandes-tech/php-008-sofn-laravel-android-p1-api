<?php

namespace SON\Http\Controllers\Api;

use Illuminate\Http\Request;
use SON\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * @param Request $request
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            $token = \JWTAuth::attempt($credentials);
        } catch (JWTException $ex) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        if (!$token) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }

        return response()->json(compact('token'));
    }

    public function logout()
    {
        try {
            \JWTAuth::invalidate();
        } catch (JWTException $ex) {
            return response()->json(['error' => 'could_not_invalidate_token'], 500);
        }

        return response()->json([], 204);
    }
}
