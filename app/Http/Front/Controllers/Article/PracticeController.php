<?php
/**
 * 社会实践记录控制器
 * Date: 2018/10/27
 * Time: 9:12
 */
namespace App\Http\Front\Controllers\Article;

use App\Http\Front\Actions\Article\Practice\IndexAction;
use App\Http\Front\Actions\Article\Practice\InfoAction;
use App\Http\Front\Controllers\Controller;
use Illuminate\Http\Request;

class PracticeController extends Controller
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
