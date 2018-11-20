<?php
/**
 * 前台登录验证
 * Date: 2018/11/20
 * Time: 14:21
 */
namespace App\Http\Wechat\Actions\Oauth;

use Common\Config\SessionConfig;
use Wechat\Action\BaseAction;
use Wechat\Traits\WechatFrontOauthTrait;

class FrontAction extends BaseAction
{
    use WechatFrontOauthTrait;

    public function run()
    {
        if (empty($this->userId)) {
            return '授权失败';
        }
        $redirectKey = SessionConfig::FRONT_OAUTH_REDIRECT_URL;
        $httpTool = $this->getHttpTool();
        $redirectUrl = $httpTool->getSession($redirectKey);
        $httpTool->removeSession($redirectKey);
        header("Location: {$redirectUrl}");
    }

    protected function renderPage($msg)
    {
        return null;
    }
}