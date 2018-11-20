<?php
/**
 * 登录验证
 * Date: 2018/11/3
 * Time: 15:25
 */
namespace Front\Traits;

use Admin\Services\User\Processor\UserProcessor;
use Carbon\Carbon;
use Common\Config\SessionConfig;
use Common\Models\User\User;
use Overtrue\Socialite\User as SocialiteUser;
use Wechat\Config\WechatConfig;

trait LoginAuthTrait
{
    protected $wechatUser = [];
    protected $userId = 0;

    public function init()
    {
        $this->wechatUser = session(SessionConfig::FRONT_USER_INFO);
        $this->userId = session(SessionConfig::FRONT_USER_ID);
        if (empty($this->userId)) {
            // TODO: 测试环境
            $this->wechatUser();
        }
    }

    public function wechatUser()
    {
        $user = new SocialiteUser([
            'id' => time(),
            'name' => 'name_'.time(),
            'nickname' => 'nickname_'.time(),
            'avatar' => '/storage/20181105/bgnOSAvr0oozKHnvjs32aQNNsRTpOSqtsjUZsVse.jpeg',
            'email' => null,
            'original' => [],
            'provider' => 'WeChat',
        ]);
        $this->userId = $this->processWechatUser($user);
        if ($this->userId) {
            session(SessionConfig::FRONT_USER_ID, $this->userId);
            session(SessionConfig::FRONT_USER_INFO, $user);
        }
        return $user;
    }

    protected function processWechatUser($wechatUser)
    {
        if (empty($wechatUser)) {
            return 0;
        }
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
    }
}
