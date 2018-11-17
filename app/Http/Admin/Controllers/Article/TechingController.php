<?php
/**
 * 教研活动控制器
 * Date: 2018/10/20
 * Time: 1:28
 */
namespace App\Http\Admin\Controllers\Article;

use App\Http\Admin\Actions\Article\Teching\IndexAction;
use App\Http\Admin\Actions\Article\Teching\InfoAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class TechingController extends Controller
{
    /**
     * 教研活动列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 教研活动详情
     * @param Request $request
     */
    public function info(Request $request)
    {
        return (new InfoAction($request))->run();
    }
}