<?php
/**
 * 中高考政策控制器
 * Date: 2018/10/27
 * Time: 9:11
 */
namespace App\Http\Front\Controllers\Article;

use App\Http\Front\Actions\Article\Exam\IndexAction;
use App\Http\Front\Actions\Article\Exam\InfoAction;
use App\Http\Front\Controllers\Controller;
use Illuminate\Http\Request;

class ExamController extends Controller
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
