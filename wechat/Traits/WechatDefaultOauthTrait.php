<?php
/**
 * 微信认证信息
 * Date: 2018/11/5
 * Time: 9:12
 */
namespace Wechat\Traits;

use Admin\Services\User\Integration\UserRegisterIntegration;
use Carbon\Carbon;
use Common\Models\User\User;
use Admin\Services\User\Processor\UserProcessor;
use Overtrue\Socialite\User as SocialiteUser;
use Wechat\Tool\WechatTool;

trait WechatDefaultOauthTrait
{
    protected $wechatUser = [];
    protected $userId = 0;

    public function init()
    {
        $this->wechatUser = $this->wechatUser();
    }

    public function wechatUser()
    {
        $sessionKey = 'wechat.oauth_user.default';
        $sessionUserKey = "userid";
        $httpTool = $this->getHttpTool();
        $user = $httpTool->getSession($sessionKey);
        $this->userId = $httpTool->getSession($sessionUserKey);
        if (empty($user)) {
            // 测试
//            $user = new SocialiteUser([
//                'id' => array_get($user, 'openid'),
//                'name' => array_get($user, 'nickname'),
//                'nickname' => array_get($user, 'nickname'),
//                'avatar' => array_get($user, 'headimgurl'),
//                'email' => null,
//                'original' => [],
//                'provider' => 'WeChat',
//            ]);
            // 测试
            $user = new SocialiteUser([
                'id' => time(),
                'name' => 'name_'.time(),
                'nickname' => 'nickname_'.time(),
                'avatar' => '/storage/20181105/bgnOSAvr0oozKHnvjs32aQNNsRTpOSqtsjUZsVse.jpeg',
                'email' => null,
                'original' => [],
                'provider' => 'WeChat',
            ]);
            // end测试
            $this->userId = $this->processWechatUser($user);
            if ($this->userId) {
                $httpTool->setSession($sessionUserKey, $this->userId);
            }
            $httpTool->setSession($sessionKey, $user);
        } else if(empty($this->userId)) {
            $this->userId = $this->processWechatUser($user);
            if ($this->userId) {
                $httpTool->setSession($sessionUserKey, $this->userId);
            }
            $httpTool->setSession($sessionKey, $user);
        }
        return $user;
    }

    protected function processWechatUser($wechatUser)
    {
        $user = User::where(['openid' => $wechatUser->id])->first();
        if (empty($user)) {
            // 测试
            $data = [
                'nick_name'         => array_get($wechatUser, 'nickname'),
                'openid'            => array_get($wechatUser, 'id'),
                'face'              => array_get($wechatUser, 'avatar'),
                'last_login_at'     => date('Y-m-d H:i:s'),
            ];
            list($status, $user) = (new UserProcessor())->insert($data);
            if ($status) {
                return $user->id;
            }
            return 0;
            // 正式
//            $wechatTool = new WechatTool();
//            $register = new UserRegisterIntegration($wechatTool->getUserInfo($wechatUser->id));
//            list($status, $errMsg, $socialiteUser, $userId) = $register->process();
//            if ($status) {
//                return $userId;
//            }
//            return 0;
        } else {
            $user->last_login_at = Carbon::now();
            $user->save();
            return $user->id;
        }
    }
}
