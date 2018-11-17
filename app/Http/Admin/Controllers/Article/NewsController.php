<?php
/**
 * 文章列表
 * Date: 2018/10/8
 * Time: 2:06
 */
namespace App\Http\Admin\Controllers\Article;

use App\Http\Admin\Actions\Article\News\IndexAction;
use App\Http\Admin\Actions\Article\News\InfoAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * 教育新闻
     * @param Request $request
     */
    public function index(Request $request)
    {
        return (new IndexAction($request))->run();
    }

    /**
     * 新闻详情
     * @param Request $request
     */
    public function info(Request $request)
    {
        return (new InfoAction($request))->run();
    }
}