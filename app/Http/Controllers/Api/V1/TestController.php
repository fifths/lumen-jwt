<?php

namespace App\Http\Controllers\Api\V1;

class TestController extends BaseController
{
    public function test()
    {
        return response()->json(['api_version' => 'v1']);
    }
}
