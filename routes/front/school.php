<?php
// 学校
Route::middleware(['web'])->group(function () {
    Route::match(['get', 'post'], '/front/school/search', [
        'uses' => '\App\Http\Front\Controllers\School\SchoolController@search'
    ])->name('front.school.search');
    Route::match(['get', 'post'], '/front/school/district/search', [
        'uses' => '\App\Http\Front\Controllers\School\DistrictController@search'
    ])->name('front.school.district.search');
});
