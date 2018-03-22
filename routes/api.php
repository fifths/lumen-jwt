<?php

$api = app('Dingo\Api\Routing\Router');
// $api = $app->make(Dingo\Api\Routing\Router::class);
$api->version(['v1', 'v2'], ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
    // test
    $api->get('test', 'TestController@test');
    $api->get('auth/register', 'AuthController@register');
    $api->get('auth/store', 'AuthController@store');
});