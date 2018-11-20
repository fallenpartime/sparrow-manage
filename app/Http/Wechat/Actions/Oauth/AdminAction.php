<?php
/**
 * 后台扫码登录验证
 * Date: 2018/11/20
 * Time: 14:21
 */
namespace App\Http\Wechat\Actions\Oauth;

use Common\Models\User\User;
use Frameworks\Tool\Cache\RedisTool;
use Wechat\Action\BaseAction;
use Wechat\Traits\WechatAdminOauthTrait;

class AdminAction extends BaseAction
{
    use WechatAdminOauthTrait;

    public function run()
    {
        if (empty($this->userId) || empty($this->wechatUser)) {
            return '授权失败';
        }
        $userId = $this->userId;
        $httpTool = $this->getHttpTool();
        $token = $httpTool->getBothSafeParam('token');
        if (empty($token)) {
            exit('参数缺失');
        }
        $tokenKey = "edu:admin:login:{$token}";
        $redisTool = new RedisTool();
        $tokenData = $redisTool->hgetall($tokenKey);
        if (empty($tokenData)) {
            exit('二维码已失效');
        }
        $frontUser = User::find($userId);
        if (empty($frontUser)) {
            exit('微信用户不存在');
        }
        if (empty($frontUser->phone)) {
            exit('微信用户未绑定电话');
        }
        $tokenData['status'] = 1;
        $tokenData['phone'] = $frontUser->phone;
        $redisTool->hmset($tokenKey, $tokenData);
        exit('授权成功');
    }
}