<?php
// 文章操作
Route::middleware(['web'])->group(function () {
    Route::post('/front/article/like', [
        'uses' => '\App\Http\Front\Controllers\Article\OperateController@like'
    ])->name('front.article.like');
});
// 教育快讯
Route::middleware(['web'])->group(function () {
    Route::match(['get', 'post'], '/front/article/news', [
        'uses' => '\App\Http\Front\Controllers\Article\NewsController@index'
    ])->name('front.news');
    Route::get('/front/article/news/{code}', [
        'uses' => '\App\Http\Front\Controllers\Article\NewsController@info'
    ])->name('front.news.info');
});
// 中高考政策
Route::middleware(['web'])->group(function () {
    Route::match(['get', 'post'], '/front/article/exam', [
        'uses' => '\App\Http\Front\Controllers\Article\ExamController@index'
    ])->name('front.exams');
    Route::get('/front/article/exam/{code}', [
        'uses' => '\App\Http\Front\Controllers\Article\ExamController@info'
    ])->name('front.exam.info');
});
// 社会实践记录
Route::middleware(['web'])->group(function () {
    Route::match(['get', 'post'], '/front/article/practice', [
        'uses' => '\App\Http\Front\Controllers\Article\PracticeController@index'
    ])->name('front.practices');
    Route::get('/front/article/practice/{code}', [
        'uses' => '\App\Http\Front\Controllers\Article\PracticeController@info'
    ])->name('front.practice.info');
});
// 教研活动
Route::middleware(['web'])->group(function () {
    Route::match(['get', 'post'], '/front/article/teching', [
        'uses' => '\App\Http\Front\Controllers\Article\TechingController@index'
    ])->name('front.techings');
    Route::get('/front/article/teching/{code}', [
        'uses' => '\App\Http\Front\Controllers\Article\TechingController@info'
    ])->name('front.teching.info');
});
