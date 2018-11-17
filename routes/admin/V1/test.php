<?php

//Route::get('/admin/test', [
//    'as' => 'admintest',
//    'uses' => '\App\Http\Admin\Controllers\Test\TestController@index'
//])->middleware('admin.login.auth', 'admin.action.auth');

Route::middleware(['web'])->group(function () {
    Route::get('/admin/test', [
        'as' => 'admintest',
        'uses' => '\App\Http\Admin\Controllers\Test\TestController@index'
    ]);
});

//$api->version('v1', function ($api) {
//    $api->get('helloworld', 'App\Api\Controllers\HelloController@index');
//});
