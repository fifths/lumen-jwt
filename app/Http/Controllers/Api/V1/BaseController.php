<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

class BaseController extends Controller
{
    use Helpers;

    public function error($errcode, $errmsg)
    {
        return response()->json([
            'errcode' => $errcode,
            'errmsg' => $errmsg
        ], 401);
    }

    public function errorValidator($errcode = 40001, $validator)
    {
        return $this->error($errcode, $validator->errors());
    }
}