<?php

$api = app('Dingo\Api\Routing\Router');
// $api = $app->make(Dingo\Api\Routing\Router::class);
$api->version(['v1', 'v2'], ['namespace' => 'App\Http\Controllers\Auth'], function ($api) {
    // register
    $api->post('register', 'AuthenticateController@register');
    // login get token
    $api->post('login', 'AuthenticateController@authenticate');
    // need authentication
    $api->group(['middleware' => 'api.auth'], function ($api) {
        // get current token
        $api->get('authenticate/current', 'AuthenticateController@getCurrentToken');
        // get user info
        $api->get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');
        // refresh token
        $api->put('authenticate/refresh', 'AuthenticateController@refreshToken');
        // delete token
        $api->delete('authenticate/delete', 'AuthenticateController@deleteToken');
    });
});
// v1
// header    Accept:application/vnd.lumen.v1+json
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
    // test
    $api->get('test', function () {
        $data = ['msg' => 'this is v1 api'];
        return $data;
    });
    // need authentication
    $api->group(['middleware' => 'api.auth'], function ($api) {
        // User
        // my detail
        $api->get('user', ['as' => 'user.show', 'uses' => 'UserController@show']);
        // update info
        $api->patch('user', ['as' => 'users.update', 'uses' => 'UserController@patch']);
        // edit password
        $api->put('user/password', ['as' => 'user.edit.password', 'uses' => 'UserController@editPassword']);
        // Post
        $api->get('/post', 'PostController@index');
        $api->post('/post', 'PostController@create');
        $api->put('/post/{postId}', 'PostController@update');
    });
});
// v2
// header    Accept:application/vnd.lumen.v2+json
$api->version('v2', ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
    // test
    $api->get('test', function () {
        $data = ['msg' => 'this is v2 api'];
        return $data;
    });
});