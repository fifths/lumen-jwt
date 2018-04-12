<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{

    public function __construct()
    {
        $this->middleware('api.auth');
    }

    public function show()
    {
        return $this->user();
    }

    public function patch(Request $request)
    {
        $rules = [
            'name' => 'string|between:3,15',
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
            'new_password' => 'required|confirmed|different:password|between:3,15',
            'new_password_confirmation' => 'required|same:new_password|between:3,15',
        ];
        $this->validate($request, $rules);
        $attributes = array_filter($request->only('password', 'new_password', 'new_password_confirmation'));
        $user = $this->user();
        $credentials['email'] = $user->email;
        $credentials['password'] = $request->input('password');
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['errcode' => 40001, 'errmsg' => 'Unauthorized.'], 401);
        }
        if ($attributes) {
            $password = app('hash')->make($request->get('new_password'));
            $user->password = $password;
            $rs = $user->save();
            return response()->json(compact('rs'));
        }

    }
}