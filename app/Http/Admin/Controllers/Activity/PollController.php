<?php
/**
 * 网络投票控制器
 * Date: 2018/10/20
 * Time: 22:16
 */
namespace App\Http\Admin\Controllers\Activity;

use App\Http\Admin\Actions\Activity\Poll\IndexAction;
use App\Http\Admin\Actions\Activity\Poll\InfoAction;
use App\Http\Admin\Actions\Activity\Poll\Question\IndexAction as QuestionIndexAction;
use App\Http\Admin\Actions\Activity\Poll\Question\InfoAction as QuestionInfoAction;
use App\Http\Admin\Actions\Activity\Poll\Question\IndexDataAction;
use App\Http\Admin\Actions\Activity\Poll\Vote\IndexAction as VoteIndexAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class PollController extends Controller
{

    /**
     * 网络投票活动列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 网络投票活动详情
     * @param Request $request
     */
    public function info(Request $request)
    {
        return (new InfoAction($request))->run();
    }

    /**
     * 投票问题列表
     * @param Request $request
     */
    public function questions(Request $request)
    {
        return (new QuestionIndexAction($request))->run();
    }

    /**
     * 投票问题详情
     * @param Request $request
     */
    public function questionInfo(Request $request)
    {
        return (new QuestionInfoAction($request))->run();
    }

    /**
     * 活动投票汇总
     * @param Request $request
     */
    public function activityVotes(Request $request)
    {
        return (new IndexDataAction($request))->run();
    }

    /**
     * 活动投票明细
     * @param Request $request
     */
    public function votes(Request $request)
    {
        return (new VoteIndexAction($request))->run();
    }
}
