<?php
// 文章
Route::middleware(['web', 'admin.login.auth', 'admin.action.auth'])->group(function () {
    // 教育资讯
    Route::get('/admin/article/news', [
        'uses' => '\App\Http\Admin\Controllers\Article\NewsController@index'
    ])->name('news');
    Route::match(['get', 'post'], '/admin/article/news/info', [
        'uses' => '\App\Http\Admin\Controllers\Article\NewsController@info'
    ])->name('articleNewsInfo');
    // 中高考政策
    Route::get('/admin/article/exams', [
        'uses' => '\App\Http\Admin\Controllers\Article\ExamController@index'
    ])->name('exams');
    Route::match(['get', 'post'], '/admin/article/exam/info', [
        'uses' => '\App\Http\Admin\Controllers\Article\ExamController@info'
    ])->name('articleExamInfo');
    // 社会实践记录
    Route::get('/admin/article/practices', [
        'uses' => '\App\Http\Admin\Controllers\Article\PracticeController@index'
    ])->name('practices');
    Route::match(['get', 'post'], '/admin/article/practice/info', [
        'uses' => '\App\Http\Admin\Controllers\Article\PracticeController@info'
    ])->name('articlePracticeInfo');
    // 教研活动
    Route::get('/admin/article/techings', [
        'uses' => '\App\Http\Admin\Controllers\Article\TechingController@index'
    ])->name('techings');
    Route::match(['get', 'post'], '/admin/article/teching/info', [
        'uses' => '\App\Http\Admin\Controllers\Article\TechingController@info'
    ])->name('articleTechingInfo');
    // 文章操作
    Route::match(['post'], '/admin/article/show', [
        'uses' => '\App\Http\Admin\Controllers\Article\OperateController@show'
    ])->name('articleShow');
    Route::match(['post'], '/admin/article/remove', [
        'uses' => '\App\Http\Admin\Controllers\Article\OperateController@remove'
    ])->name('articleRemove');
    Route::match(['post'], '/admin/article/fresh', [
        'uses' => '\App\Http\Admin\Controllers\Article\OperateController@fresh'
    ])->name('articleFresh');
});
