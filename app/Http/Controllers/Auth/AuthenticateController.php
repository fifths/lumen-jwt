<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthenticateController extends BaseController
{

    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:4'
        ]);
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => (new BcryptHasher)->make($request->input('password')),
        ]);
        $token = $this->auth->fromUser($user);
        return response()->json(compact('token'));
    }

    public function authenticate(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:4'
        ]);
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = $this->auth->attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        $user = User::where('email', $credentials['email'])->first();
        return ['user' => $user, 'token' => $token];
    }

    public function getAuthenticatedUser()
    {
        try {
            if (!$user = $this->auth->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    public function refreshToken(Request $request)
    {
        $token = $this->auth->refresh();
        return ['token' => $token];
    }

    public function deleteToken(Request $request)
    {
        $this->auth->refresh();
        return ['token' => ''];
    }

    public function getCurrentToken()
    {
        // Token
        $token = $this->auth->getToken()->get();
        // Payload
        // $token = $this->auth->getPayload()->get();
        return ['token' => $token];
    }
}