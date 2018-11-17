<?php
/**
 * 网络投票活动控制器
 * Date: 2018/10/27
 * Time: 9:16
 */
namespace App\Http\Front\Controllers\Activity;

use App\Http\Front\Actions\Activity\Poll\IndexAction;
use App\Http\Front\Actions\Activity\Poll\InfoAction;
use App\Http\Front\Controllers\Controller;
use Illuminate\Http\Request;

class PollController extends Controller
{

    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    public function info(Request $request)
    {
        return (new InfoAction($request))->run();
    }
}
