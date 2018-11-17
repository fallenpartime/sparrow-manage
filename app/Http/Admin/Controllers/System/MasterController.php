<?php

namespace App\Http\Admin\Controllers\System;

use App\Http\Admin\Actions\Master\AuthorityAction;
use App\Http\Admin\Actions\Master\DetailAction;
use App\Http\Admin\Actions\Master\IndexAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function owners(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    public function ownerInfo(Request $request)
    {
        return (new DetailAction($request))->run();
    }

    public function ownerAuthority(Request $request)
    {
        return (new AuthorityAction($request))->run();
    }
}
