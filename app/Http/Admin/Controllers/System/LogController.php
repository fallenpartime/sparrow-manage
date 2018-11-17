<?php
/**
 * 日志控制器
 * Date: 2018/10/20
 * Time: 1:49
 */
namespace App\Http\Admin\Controllers\System;

use App\Http\Admin\Actions\System\Log\IndexAdminAction;
use App\Http\Admin\Actions\System\Log\IndexOperateAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class LogController extends Controller
{

    /**
     * 操作日志
     * @param Request $request
     */
    public function operateLogs(Request $request)
    {
        return (new IndexOperateAction($request))->run();
    }

    /**
     * 权限中心日志
     * @param Request $request
     */
    public function adminLogs(Request $request)
    {
        return (new IndexAdminAction($request))->run();
    }
}