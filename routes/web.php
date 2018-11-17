<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

$api = app('Dingo\Api\Routing\Router');
require __DIR__.'/admin/V1/test.php';
require __DIR__.'/admin/system.php';
require __DIR__.'/admin/school.php';
require __DIR__.'/admin/article.php';
require __DIR__.'/admin/activity.php';
require __DIR__.'/admin/interact.php';
require __DIR__.'/admin/upload.php';
require __DIR__.'/front/article.php';
require __DIR__.'/front/activity.php';
require __DIR__.'/front/school.php';
require __DIR__.'/front/interact.php';
require __DIR__.'/wechat/wechat.php';
