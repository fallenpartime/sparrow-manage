<?php
/**
 * 投票控制器
 * Date: 2018/10/30
 * Time: 17:08
 */
namespace App\Http\Front\Controllers\Activity;

use App\Http\Front\Actions\Activity\Vote\FeedbackAction;
use App\Http\Front\Actions\Activity\Vote\InfoAction;
use App\Http\Front\Controllers\Controller;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * 投票表单
     * @param Request $request
     */
    public function info(Request $request)
    {
        return (new InfoAction($request))->run();
    }

    public function feedback(Request $request)
    {
        return (new FeedbackAction($request))->run();
    }
}
