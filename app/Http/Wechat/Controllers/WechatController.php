<?php
/**
 * 微信控制器
 * Date: 2018/11/16
 * Time: 23:22
 */
namespace App\Http\Wechat\Controllers;

use Frameworks\Controller\Controller;
use Illuminate\Http\Request;

class WechatController extends Controller
{
    public function index(Request $request)
    {
        $request->request->all();
    }
}