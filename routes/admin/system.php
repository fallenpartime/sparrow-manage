<?php
Route::middleware(['web'])->group(function () {
    Route::get('/admin/warn', [
        'as' => 'admin.warn',
        'uses' => '\App\Http\Admin\Controllers\Site\SiteController@warn'
    ]);
    Route::match(['get', 'post'], '/admin/login', [
        'uses' => '\App\Http\Admin\Controllers\Site\SiteController@login'
    ])->name('admin.login');
    Route::get('/admin/check', [
        'uses' => '\App\Http\Admin\Controllers\Site\SiteController@check'
    ])->name('admin.check');
    Route::get('/admin/qrcode', [
        'uses' => '\App\Http\Admin\Controllers\Site\SiteController@qrcode'
    ])->name('admin.qrcode');
});
Route::middleware(['web', 'admin.login.auth', 'admin.action.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/index', [
        'uses' => '\App\Http\Admin\Controllers\System\SystemController@index'
    ])->name('index');
    Route::get('/admin/authorities', [
        'uses' => '\App\Http\Admin\Controllers\System\SystemController@authorities'
    ])->name('authorities');
    Route::match(['get', 'post'], '/admin/authority/info', [
        'uses' => '\App\Http\Admin\Controllers\System\SystemController@authorityInfo'
    ])->name('authorityInfo');
    Route::get('/admin/groups', [
        'uses' => '\App\Http\Admin\Controllers\System\SystemController@groups'
    ])->name('groups');
    Route::match(['get', 'post'], '/admin/group/info', [
        'uses' => '\App\Http\Admin\Controllers\System\SystemController@groupInfo'
    ])->name('groupInfo');
    Route::get('/admin/roles', [
        'uses' => '\App\Http\Admin\Controllers\System\SystemController@roles'
    ])->name('roles');
    Route::match(['get', 'post'], '/admin/role/info', [
        'uses' => '\App\Http\Admin\Controllers\System\SystemController@roleInfo'
    ])->name('roleInfo');
    Route::get('/admin/owners', [
        'uses' => '\App\Http\Admin\Controllers\System\MasterController@owners'
    ])->name('owners');
    Route::match(['get', 'post'], '/admin/owner/info', [
        'uses' => '\App\Http\Admin\Controllers\System\MasterController@ownerInfo'
    ])->name('ownerInfo');
    Route::match(['get', 'post'], '/admin/owner/authority', [
        'uses' => '\App\Http\Admin\Controllers\System\MasterController@ownerAuthority'
    ])->name('ownerAuthority');
});
Route::middleware(['web', 'admin.login.auth', 'admin.action.auth'])->group(function () {
    Route::get('/admin/log/operates', [
        'uses' => '\App\Http\Admin\Controllers\System\LogController@operateLogs'
    ])->name('operateLogs');
    Route::get('/admin/log/admin/operates', [
        'uses' => '\App\Http\Admin\Controllers\System\LogController@adminLogs'
    ])->name('adminLogs');
});
