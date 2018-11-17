<?php
// 投票操作
Route::middleware(['web'])->group(function () {
    Route::match(['get', 'post'], '/front/activity/vote', [
        'uses' => '\App\Http\Front\Controllers\Activity\VoteController@info'
    ])->name('front.activity.vote');
    Route::match(['get', 'post'], '/front/activity/feedback', [
        'uses' => '\App\Http\Front\Controllers\Activity\VoteController@feedback'
    ])->name('front.activity.feedback');
});
// 活动操作
Route::middleware(['web'])->group(function () {
    Route::post('/front/activity/like', [
        'uses' => '\App\Http\Front\Controllers\Activity\OperateController@like'
    ])->name('front.activity.like');
});
// 网络投票
Route::middleware(['web'])->group(function () {
    Route::match(['get', 'post'], '/front/activity/polls', [
        'uses' => '\App\Http\Front\Controllers\Activity\PollController@index'
    ])->name('front.polls');
    Route::get('/front/activity/poll/{code}', [
        'uses' => '\App\Http\Front\Controllers\Activity\PollController@info'
    ])->name('front.poll.info');
});
