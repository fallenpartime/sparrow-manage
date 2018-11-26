<?php
// 投票操作
Route::group(function () {
    Route::match(['get', 'post'], '/front/activity/vote', [
        'uses' => '\App\Http\Front\Controllers\Activity\VoteController@info'
    ])->middleware(['web','front.login.auth'])->name('front.activity.vote');
    Route::match(['get', 'post'], '/front/activity/feedback', [
        'uses' => '\App\Http\Front\Controllers\Activity\VoteController@feedback'
    ])->middleware(['web'])->name('front.activity.feedback');
});
// 活动操作
Route::middleware(['web'])->group(function () {
    Route::post('/front/activity/like', [
        'uses' => '\App\Http\Front\Controllers\Activity\OperateController@like'
    ])->name('front.activity.like');
});
// 网络投票
Route::group(function () {
    Route::match(['get', 'post'], '/front/activity/polls', [
        'uses' => '\App\Http\Front\Controllers\Activity\PollController@index'
    ])->middleware(['web'])->name('front.polls');
    Route::get('/front/activity/poll/{code}', [
        'uses' => '\App\Http\Front\Controllers\Activity\PollController@info'
    ])->middleware(['web','front.login.auth'])->name('front.poll.info');
});
