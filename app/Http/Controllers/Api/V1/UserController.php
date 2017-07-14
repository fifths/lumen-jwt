<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;
use App\Models\User;

class UserController extends BaseController
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        return $user;
    }

    public function showMe()
    {
        return $this->user();
    }
}