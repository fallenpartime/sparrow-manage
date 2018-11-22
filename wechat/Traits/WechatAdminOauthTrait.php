<?php
/**
 * 后台验证
 * Date: 2018/11/20
 * Time: 22:53
 */
namespace Wechat\Traits;

use Admin\Services\User\Processor\UserProcessor;
use Carbon\Carbon;
use Common\Models\User\User;
use Overtrue\Socialite\User as SocialiteUser;
use Wechat\Config\WechatConfig;

trait WechatAdminOauthTrait
{
    protected $wechatUser = [];
    protected $userId = 0;

    public function init()
    {
        $this->wechatUser = $this->wechatUser();
    }

    public function wechatUser()
    {
        $sessionKey = WechatConfig::DEFAULT_OFFICIAL_DEFAULT_USER;
        $httpTool = $this->getHttpTool();
        $user = $httpTool->getSession($sessionKey);
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
//            $user = new SocialiteUser([
//                'id' => time(),
//                'name' => 'name_'.time(),
//                'nickname' => 'nickname_'.time(),
//                'avatar' => '/storage/20181105/bgnOSAvr0oozKHnvjs32aQNNsRTpOSqtsjUZsVse.jpeg',
//                'email' => null,
//                'original' => [],
//                'provider' => 'WeChat',
//            ]);
        }
        $this->userId = $this->processWechatUser($user);
        return $user;
    }

    protected function processWechatUser($wechatUser)
    {
        if (empty($wechatUser)) {
            return 0;
        }
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