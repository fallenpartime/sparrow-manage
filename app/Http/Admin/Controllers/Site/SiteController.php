<?php
/**
 * 入口控制器
 * Date: 2018/10/2
 * Time: 22:59
 */
namespace App\Http\Admin\Controllers\Site;

use App\Http\Admin\Actions\Site\CheckAction;
use App\Http\Admin\Actions\Site\LoginAction;
use App\Http\Admin\Actions\Site\QrcodeAction;
use App\Http\Admin\Actions\Site\WarnAction;
use App\Http\Admin\Controllers\Controller;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function login(Request $request) {
        return (new LoginAction($request))->run();
    }

    public function check(Request $request) {
        return (new CheckAction($request))->run();
    }

    public function qrcode(Request $request) {
        return (new QrcodeAction($request))->run();
    }

    public function warn(Request $request) {
        return (new WarnAction($request))->run();
    }
}