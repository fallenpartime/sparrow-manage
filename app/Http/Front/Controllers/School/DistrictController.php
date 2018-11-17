<?php
/**
 * 学区查询
 * Date: 2018/10/27
 * Time: 9:42
 */
namespace App\Http\Front\Controllers\School;

use App\Http\Front\Actions\School\District\IndexAction;
use App\Http\Front\Controllers\Controller;
use Illuminate\Http\Request;

class DistrictController extends Controller
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
