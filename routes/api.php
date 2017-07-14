<?php
$api = app('Dingo\Api\Routing\Router');
//$api = $app->make(Dingo\Api\Routing\Router::class);

$api->version(['v1', 'v2'], ['namespace' => 'App\Http\Controllers\Auth', 'middleware' => ['cors']], function ($api) {
    //获取token
    $api->post('auth/token', 'AuthenticateController@authenticate');
});

// v1
// header    Accept:application/vnd.lumen.v1+json
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


    // need authentication
    $api->group(['middleware' => 'api.auth'], function ($api) {

        // User
        // my detail
        $api->get('user', [
            'as' => 'user.show',
            'uses' => 'UserController@showMe',
        ]);

        // Post
        $api->get('/posts', 'PostController@index');
        $api->post('/posts', 'PostController@create');
        $api->put('/posts/{postId}', 'PostController@update');
    });
});

// v2
// header    Accept:application/vnd.lumen.v2+json
$api->version('v2', ['namespace' => 'App\Http\Controllers\Api\V1', 'middleware' => ['cors']], function ($api) {
    // test
    $api->get('test', function () {
        $data = ['msg' => 'this is v2'];
        return $data;
    });
});