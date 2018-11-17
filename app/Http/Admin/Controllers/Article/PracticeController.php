<?php
/**
 * 社会实践控制器
 * Date: 2018/10/20
 * Time: 1:28
 */
namespace App\Http\Admin\Controllers\Article;

use App\Http\Admin\Actions\Article\Practice\IndexAction;
use App\Http\Admin\Actions\Article\Practice\InfoAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class PracticeController extends Controller
{
    /**
     * 社会实践记录列表
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 社会实践记录详情
     * @param Request $request
     */
    public function info(Request $request)
    {
        return (new InfoAction($request))->run();
    }
}