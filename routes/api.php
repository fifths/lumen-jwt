<?php
$api = app('Dingo\Api\Routing\Router');

$api->version(['v1', 'v2'], ['namespace' => 'App\Http\Controllers\Auth'], function ($api) {
    //获取token
    $api->post('auth/token', 'AuthenticateController@authenticate');
});

// 版本 v1
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => ['cors']], function ($api) {

    // test
    $api->get('test', function () {
        $data = ['msg' => 'this is v1'];
        return $data;
    });

    // User
    // user detail
    $api->get('users/{id}', [
        'as' => 'users.show',
        'uses' => 'UserController@show',
    ]);


    // Post
    $api->get('/posts', 'PostController@index');
    $api->post('/posts', 'PostController@create');
    $api->put('/posts/{postId}', 'PostController@update');
});

// 版本 v2
$api->version('v2', ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
    // test
    $api->get('test', function () {
        $data = ['msg' => 'this is v2'];
        return $data;
    });
});