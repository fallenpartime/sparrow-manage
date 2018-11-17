<?php

namespace App\Http\Admin\Controllers\School;

use App\Http\Admin\Actions\School\District\DetailAction;
use App\Http\Admin\Actions\School\District\IndexAction;
use App\Http\Admin\Actions\School\District\ShowAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class DistrictController extends Controller
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
