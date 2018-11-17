<?php
// 学区
Route::middleware(['web', 'admin.login.auth', 'admin.action.auth'])->group(function () {
    Route::get('/admin/districts', [
        'uses' => '\App\Http\Admin\Controllers\School\DistrictController@index'
    ])->name('districts');
    Route::match(['get', 'post'], '/admin/district/info', [
        'uses' => '\App\Http\Admin\Controllers\School\DistrictController@detail'
    ])->name('districtInfo');
    Route::match(['post'], '/admin/district/show', [
        'uses' => '\App\Http\Admin\Controllers\School\DistrictController@show'
    ])->name('districtShow');
});
// 学校
Route::middleware(['web', 'admin.login.auth', 'admin.action.auth'])->group(function () {
    Route::get('/admin/schools', [
        'uses' => '\App\Http\Admin\Controllers\School\SchoolController@index'
    ])->name('schools');
    Route::match(['get', 'post'], '/admin/school/info', [
        'uses' => '\App\Http\Admin\Controllers\School\SchoolController@detail'
    ])->name('schoolInfo');
    Route::match(['post'], '/admin/school/show', [
        'uses' => '\App\Http\Admin\Controllers\School\SchoolController@show'
    ])->name('schoolShow');
});