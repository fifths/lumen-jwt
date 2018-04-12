<?php

$api = app('Dingo\Api\Routing\Router');

// default v1 version API

// header  Accept:application/vnd.lumen.v1+json
$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api\V1',
    'middleware' => ['cors']
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
        $api->get('me', [
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

    // need authentication
    $api->group([
        // 'middleware' => 'api.auth'
    ], function ($api) {
        // User
        // my detail
        $api->get('user', [
            'as' => 'user.show',
            'uses' => 'UserController@show'
        ]);
        // update info
        $api->patch('user', [
            'as' => 'users.update',
            'uses' => 'UserController@patch'
        ]);
        // edit password
        $api->put('user/password', [
            'as' => 'user.edit.password',
            'uses' => 'UserController@editPassword'
        ]);

        // RESTful
        $api->resource('/user', 'UserController');
        $api->resource('/post', 'PostController');
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