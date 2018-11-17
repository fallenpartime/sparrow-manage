<?php
// 活动操作
Route::middleware(['web', 'admin.login.auth', 'admin.action.auth'])->group(function () {
    Route::match(['post'], '/admin/activity/show', [
        'uses' => '\App\Http\Admin\Controllers\Activity\OperateController@show'
    ])->name('activityShow');
    Route::match(['post'], '/admin/activity/remove', [
        'uses' => '\App\Http\Admin\Controllers\Activity\OperateController@remove'
    ])->name('activityRemove');
    Route::match(['post'], '/admin/activity/open', [
        'uses' => '\App\Http\Admin\Controllers\Activity\OperateController@open'
    ])->name('activityOpen');
    Route::match(['post'], '/admin/activity/fresh', [
        'uses' => '\App\Http\Admin\Controllers\Activity\OperateController@fresh'
    ])->name('activityFresh');
});
// 问题操作
Route::middleware(['web', 'admin.login.auth', 'admin.action.auth'])->group(function () {
    Route::match(['post'], '/admin/activity/question/show', [
        'uses' => '\App\Http\Admin\Controllers\Activity\OperateController@questionShow'
    ])->name('activityQuestionShow');
    Route::match(['post'], '/admin/activity/question/remove', [
        'uses' => '\App\Http\Admin\Controllers\Activity\OperateController@questionRemove'
    ])->name('activityQuestionRemove');
});
// 网络投票活动
Route::middleware(['web', 'admin.login.auth', 'admin.action.auth'])->group(function () {
    Route::get('/admin/activity/polls', [
        'uses' => '\App\Http\Admin\Controllers\Activity\PollController@index'
    ])->name('polls');
    Route::match(['get', 'post'], '/admin/activity/poll/info', [
        'uses' => '\App\Http\Admin\Controllers\Activity\PollController@info'
    ])->name('activityPollInfo');
    Route::get('/admin/activity/poll/questions', [
        'uses' => '\App\Http\Admin\Controllers\Activity\PollController@questions'
    ])->name('activityPollQuestions');
    Route::match(['get', 'post'], '/admin/activity/poll/question/info', [
        'uses' => '\App\Http\Admin\Controllers\Activity\PollController@questionInfo'
    ])->name('activityPollQuestionInfo');
    Route::get('/admin/activity/poll/vote/data', [
        'uses' => '\App\Http\Admin\Controllers\Activity\PollController@activityVotes'
    ])->name('activityPollVoteData');
    Route::get('/admin/activity/poll/votes', [
        'uses' => '\App\Http\Admin\Controllers\Activity\PollController@votes'
    ])->name('activityPollVotes');
});
