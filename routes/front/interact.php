<?php
// 师生互动
Route::group(function () {
    Route::get('/front/interact/admonitions', [
        'uses' => '\App\Http\Front\Controllers\Interact\AdmonitionController@index'
    ])->middleware(['web','front.login.auth'])->name('front.admonitions');
    Route::match(['get', 'post'], '/front/interact/admonition/consult', [
        'uses' => '\App\Http\Front\Controllers\Interact\AdmonitionController@consult'
    ])->middleware(['web','front.login.auth'])->name('front.admonition.consult');
    Route::get('/front/interact/admonition/feedback', [
        'uses' => '\App\Http\Front\Controllers\Interact\AdmonitionController@feedback'
    ])->middleware(['web'])->name('front.admonition.feedback');
});