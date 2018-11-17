<?php
/**
 * 活动操作控制器
 * Date: 2018/10/27
 * Time: 9:20
 */
namespace App\Http\Front\Controllers\Activity;

use App\Http\Front\Actions\Activity\Operate\LikeAction;
use App\Http\Front\Controllers\Controller;
use Illuminate\Http\Request;

class OperateController extends Controller
{
    /**
     * 活动点赞
     * @param Request $request
     */
    public function like(Request $request)
    {
        return (new LikeAction($request))->run();
    }
}
