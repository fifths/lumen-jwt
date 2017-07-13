<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\BaseController;

class UserController extends BaseController
{
    public function show()
    {
        $data = array(
            'name' => 'lee',
        );
        return $data;
    }
}