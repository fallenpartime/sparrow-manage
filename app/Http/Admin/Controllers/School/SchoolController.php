<?php

namespace App\Http\Admin\Controllers\School;

use App\Http\Admin\Actions\School\School\DetailAction;
use App\Http\Admin\Actions\School\School\IndexAction;
use App\Http\Admin\Actions\School\School\ShowAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    public function detail(Request $request)
    {
        return (new DetailAction($request))->run();
    }

    public function show(Request $request)
    {
        return (new ShowAction($request))->run();
    }
}
