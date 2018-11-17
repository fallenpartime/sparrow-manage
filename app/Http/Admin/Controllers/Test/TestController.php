<?php

namespace App\Http\Admin\Controllers\Test;

use App\Http\Admin\Actions\Test\IndexAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function index(Request $request) {
//        dd(asset('storage/file.txt'));
//        Storage::disk('public')->put('file.txt', 'Contentss');
        return (new IndexAction($request))->run();
    }
}
