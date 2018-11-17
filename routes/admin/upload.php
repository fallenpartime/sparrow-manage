<?php
// 上传
Route::middleware(['web', 'admin.login.auth'])->group(function () {
    Route::match(['get', 'post'], '/admin/upload', [
        'uses' => '\App\Http\Admin\Controllers\Upload\UploadController@upload'
    ])->name('upload');
});
