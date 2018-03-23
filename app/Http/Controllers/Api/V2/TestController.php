<?php

namespace App\Http\Controllers\Api\V2;

class TestController extends BaseController
{
    public function test()
    {
        return response()->json(['api_version' => 'v2']);
    }
}
