<?php
/**
 * 用户意见控制器
 * Date: 2018/10/22
 * Time: 3:41
 */
namespace App\Http\Admin\Controllers\Interact;

use App\Http\Admin\Actions\Interact\Admonition\IndexAction;
use App\Http\Admin\Actions\Interact\Admonition\RemoveAction;
use App\Http\Admin\Actions\Interact\Admonition\ReplyAction;
use App\Http\Admin\Actions\Interact\Admonition\ShowAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class AdmonitionController extends Controller
{
    /**
     * 用户意见列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 用户意见作废
     * @param Request $request
     */
    public function remove(Request $request)
    {
        return (new RemoveAction($request))->run();
    }

    /**
     * 用户意见回复
     * @param Request $request
     */
    public function reply(Request $request)
    {
        return (new ReplyAction($request))->run();
    }

    /**
     * 用户意见显示状态修改
     * @param Request $request
     */
    public function show(Request $request)
    {
        return (new ShowAction($request))->run();
    }
}
