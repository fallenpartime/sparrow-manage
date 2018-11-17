<?php
/**
 * 学校查询
 * Date: 2018/10/27
 * Time: 9:39
 */
namespace App\Http\Front\Controllers\School;

use App\Http\Front\Actions\School\School\IndexAction;
use App\Http\Front\Controllers\Controller;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * 教育机构查询
     * @param Request $request
     */
    public function search(Request $request)
    {
        return (new IndexAction($request))->run();
    }
}