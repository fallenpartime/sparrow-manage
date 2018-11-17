<?php

namespace App\Http\Admin\Controllers;

use App\Http\Admin\Actions\IndexAction;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }
}
