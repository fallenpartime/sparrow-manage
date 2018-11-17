<?php

namespace App\Http\Admin\Controllers\System;

use App\Http\Admin\Actions\System\IndexAction as LoginIndexAction;
use App\Http\Admin\Actions\System\Authority\DetailAction;
use App\Http\Admin\Actions\System\Authority\IndexAction;
use App\Http\Admin\Actions\System\Group\IndexAction as GroupIndexAction;
use App\Http\Admin\Actions\System\Group\DetailAction as GroupDetailAction;
use App\Http\Admin\Actions\System\Role\IndexAction as RoleIndexAction;
use App\Http\Admin\Actions\System\Role\DetailAction as RoleDetailAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class SystemController extends Controller
{

    public function index(Request $request)
    {
        return (new LoginIndexAction($request))->run();
    }

    public function authorities(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    public function authorityInfo(Request $request)
    {
        return (new DetailAction($request))->run();
    }

    public function groups(Request $request)
    {
        return (new GroupIndexAction($request))->run();
    }

    public function groupInfo(Request $request)
    {
        return (new GroupDetailAction($request))->run();
    }

    public function roles(Request $request)
    {
        return (new RoleIndexAction($request))->run();
    }

    public function roleInfo(Request $request)
    {
        return (new RoleDetailAction($request))->run();
    }
}
