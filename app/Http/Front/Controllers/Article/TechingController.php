<?php
/**
 * 教研活动控制器
 * Date: 2018/10/27
 * Time: 9:13
 */
namespace App\Http\Front\Controllers\Article;

use App\Http\Front\Actions\Article\Teching\IndexAction;
use App\Http\Front\Actions\Article\Teching\InfoAction;
use App\Http\Front\Controllers\Controller;
use Illuminate\Http\Request;

class TechingController extends Controller
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
