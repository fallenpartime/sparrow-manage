<?php
/**
 * Wechat controller
 * Date: 2018/11/5
 * Time: 8:46
 */
namespace App\Http\Wechat\Controllers;

use App\Http\Wechat\Actions\ServiceAction;
use Illuminate\Http\Request;

class WechatController extends Controller
{

    public function service(Request $request)
    {
        return (new ServiceAction($request))->run();
    }
}
