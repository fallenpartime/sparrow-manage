<?php
// 验证
Route::middleware(['web'])->group(function () {
    // 服务
    Route::match(['get', 'post'], '/wechat', [
        'uses' => '\App\Http\Wechat\Controllers\WechatController@service'
    ])->name('wechat.service');
});

Route::middleware(['web', 'wechat.oauth'])->group(function () {
    // 扫码验证
//    Route::match(['get', 'post'], '/wechat/oauth/scan', [
//        'uses' => '\App\Http\Wechat\Controllers\Oauth\OauthController@scan'
//    ])->name('wechat.oauth.scan');
    // 授权登录
//    Route::any('/wechat/oauth/redirect', [
//        'uses' => '\App\Http\Wechat\Controllers\Oauth\OauthController@redirectTo'
//    ])->name('wechat.oauth.redirect');
    // 后台授权登录
//    Route::any('/wechat/oauth/admin', [
//        'uses' => '\App\Http\Wechat\Controllers\Oauth\OauthController@admin'
//    ])->name('wechat.oauth.admin');
});
