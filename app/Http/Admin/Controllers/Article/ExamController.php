<?php
/**
 * 中高考控制器
 * Date: 2018/10/20
 * Time: 1:28
 */
namespace App\Http\Admin\Controllers\Article;

use App\Http\Admin\Actions\Article\Exam\IndexAction;
use App\Http\Admin\Actions\Article\Exam\InfoAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    /**
     * 中高考政策
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 中高考政策详情
     * @param Request $request
     */
    public function info(Request $request)
    {
        return (new InfoAction($request))->run();
    }
}