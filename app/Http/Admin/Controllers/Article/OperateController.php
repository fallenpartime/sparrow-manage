<?php
/**
 * 文章操作
 * Date: 2018/10/8
 * Time: 2:06
 */
namespace App\Http\Admin\Controllers\Article;

use App\Http\Admin\Actions\Article\Operate\FreshAction;
use App\Http\Admin\Actions\Article\Operate\RemoveAction;
use App\Http\Admin\Actions\Article\Operate\ShowAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class OperateController extends Controller
{

    /**
     * 文章显示状态修改
     * @param Request $request
     */
    public function show(Request $request)
    {
        return (new ShowAction($request))->run();
    }

    /**
     * 文章作废
     * @param Request $request
     */
    public function remove(Request $request)
    {
        return (new RemoveAction($request))->run();
    }

    /**
     * 文章缓存刷新
     * @param Request $request
     */
    public function fresh(Request $request)
    {
        return (new FreshAction($request))->run();
    }
}
