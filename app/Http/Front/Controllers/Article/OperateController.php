<?php
/**
 * 文章操作控制器
 * Date: 2018/10/27
 * Time: 9:11
 */
namespace App\Http\Front\Controllers\Article;

use App\Http\Front\Actions\Article\Operate\LikeAction;
use App\Http\Front\Controllers\Controller;
use Illuminate\Http\Request;

class OperateController extends Controller
{
    /**
     * 文章点赞
     * @param Request $request
     */
    public function like(Request $request)
    {
        return (new LikeAction($request))->run();
    }
}
