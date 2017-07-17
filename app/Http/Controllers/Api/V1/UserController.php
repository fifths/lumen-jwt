<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class UserController extends BaseController
{
    protected $auth;

    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function show()
    {
        return $this->user();
    }

    public function patch(Request $request)
    {
        $rules = [
            'name' => 'string|max:50',
        ];
        $this->validate($request, $rules);
        $user = $this->user();
        $attributes = array_filter($request->only('name'));
        if ($attributes) {
            $user->update($attributes);
        }
        return response()->json(compact('user'));
    }

    public function editPassword(Request $request)
    {
        $rules = [
            'password' => 'required',
            'new_password' => 'required|confirmed|different:password',
            'new_password_confirmation' => 'required|same:new_password',
        ];
        $this->validate($request, $rules);
        $attributes = array_filter($request->only('password', 'new_password', 'new_password_confirmation'));
        $user = $this->user();
        $credentials['email'] = $user->email;
        $credentials['password'] = $request->input('password');
        if (!$token = $this->auth->attempt($credentials)) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }
        if ($attributes) {
            $password = app('hash')->make($request->get('new_password'));
            $user->update(['password' => $password]);
        }
        return response()->json(compact('user'));
    }
}