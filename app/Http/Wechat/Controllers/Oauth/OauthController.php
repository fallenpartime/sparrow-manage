<?php
/**
 * 验证控制器
 * Date: 2018/10/26
 * Time: 17:36
 */
namespace App\Http\Wechat\Controllers\Oauth;

use App\Http\Wechat\Actions\Oauth\RedirectAction;
use App\Http\Wechat\Actions\Oauth\ScanAction;
use App\Http\Wechat\Controllers\Controller;
use Illuminate\Http\Request;

class OauthController extends Controller
{
    /**
     * 授权后跳转
     * @param Request $request
     */
    public function redirectTo(Request $request)
    {
        return (new RedirectAction($request))->run();
    }

    /**
     * 扫码验证
     * @param Request $request
     */
    public function scan(Request $request)
    {
        return (new ScanAction($request))->run();
    }
}
