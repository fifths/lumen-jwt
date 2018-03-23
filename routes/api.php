<?php

$api = app('Dingo\Api\Routing\Router');

// default v1 version API

// header  Accept:application/vnd.lumen.v1+json
$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api\V1'
], function ($api) {
    // test
    $api->get('test', 'TestController@test');

    $api->group([
        'prefix' => 'auth',
    ], function ($api) {
        // register
        $api->post('register', [
            'as' => 'authorize.register',
            'uses' => 'AuthController@register',
        ]);

        // login
        $api->post('login', [
            'as' => 'authorize.login',
            'uses' => 'AuthController@login',
        ]);

        // refresh
        $api->post('refresh', [
            'as' => 'authorize.refresh',
            'uses' => 'AuthController@refresh',
        ]);

        // me
        $api->post('me', [
            'as' => 'authorize.me',
            'uses' => 'AuthController@me',
        ]);

        // getCurrentToken
        $api->post('token', [
            'as' => 'authorize.getCurrentToken',
            'uses' => 'AuthController@getCurrentToken',
        ]);

        // logout
        $api->post('logout', [
            'as' => 'authorize.logout',
            'uses' => 'AuthController@logout',
        ]);
    });


});

// v2  version API
// header  Accept:application/vnd.lumen.v2+json
$api->version('v2', [
    'namespace' => 'App\Http\Controllers\Api\V2'
], function ($api) {

    // test
    $api->get('test', 'TestController@test');

});