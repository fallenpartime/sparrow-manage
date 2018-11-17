<?php
/**
 * 活动操作控制器
 * Date: 2018/10/20
 * Time: 21:56
 */
namespace App\Http\Admin\Controllers\Activity;

use App\Http\Admin\Actions\Activity\Operate\FreshAction;
use App\Http\Admin\Actions\Activity\Operate\OpenAction;
use App\Http\Admin\Actions\Activity\Operate\RemoveAction;
use App\Http\Admin\Actions\Activity\Operate\Question\RemoveAction as QuestionRemoveAction;
use App\Http\Admin\Actions\Activity\Operate\ShowAction;
use App\Http\Admin\Actions\Activity\Operate\Question\ShowAction as QuestionShowAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class OperateController extends Controller
{

    /**
     * 活动开启状态修改
     * @param Request $request
     */
    public function open(Request $request)
    {
        return (new OpenAction($request))->run();
    }

    /**
     * 活动作废
     * @param Request $request
     */
    public function remove(Request $request)
    {
        return (new RemoveAction($request))->run();
    }

    /**
     * 活动显示状态修改
     * @param Request $request
     */
    public function show(Request $request)
    {
        return (new ShowAction($request))->run();
    }

    /**
     * 问题作废
     * @param Request $request
     */
    public function questionRemove(Request $request)
    {
        return (new QuestionRemoveAction($request))->run();
    }

    /**
     * 问题显示状态修改
     * @param Request $request
     */
    public function questionShow(Request $request)
    {
        return (new QuestionShowAction($request))->run();
    }

    /**
     * 活动缓存刷新
     * @param Request $request
     */
    public function fresh(Request $request)
    {
        return (new FreshAction($request))->run();
    }
}