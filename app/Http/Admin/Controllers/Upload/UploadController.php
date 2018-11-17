<?php

namespace App\Http\Admin\Controllers\Upload;

use App\Http\Admin\Actions\Upload\UploadAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        return (new UploadAction($request))->run();
    }
}
