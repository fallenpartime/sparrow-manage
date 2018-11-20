<?php
/**
 * 后台扫码登录验证
 * Date: 2018/11/20
 * Time: 14:21
 */
namespace App\Http\Wechat\Actions\Oauth;

use Wechat\Action\BaseAction;
use Wechat\Traits\WechatAdminOauthTrait;

class AdminAction extends BaseAction
{
    use WechatAdminOauthTrait;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $token = $httpTool->getBothSafeParam('token');
        $code = $httpTool->getBothSafeParam('code');
    }



    protected function renderPage($msg)
    {
        return null;
    }
}