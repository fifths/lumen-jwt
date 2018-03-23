<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

class BaseController extends Controller
{
    use Helpers;

    public function error($validator)
    {
        return $validator->errors();
    }
}