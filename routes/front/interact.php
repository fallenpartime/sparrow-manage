<?php
// 师生互动
Route::middleware(['web'])->group(function () {
    Route::get('/front/interact/admonitions', [
        'uses' => '\App\Http\Front\Controllers\Interact\AdmonitionController@index'
    ])->name('front.admonitions');
    Route::match(['get', 'post'], '/front/interact/admonition/consult', [
        'uses' => '\App\Http\Front\Controllers\Interact\AdmonitionController@consult'
    ])->name('front.admonition.consult');
    Route::get('/front/interact/admonition/feedback', [
        'uses' => '\App\Http\Front\Controllers\Interact\AdmonitionController@feedback'
    ])->name('front.admonition.feedback');
});