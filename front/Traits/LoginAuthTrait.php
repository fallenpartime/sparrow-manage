<?php
/**
 * 登录验证
 * Date: 2018/11/3
 * Time: 15:25
 */
namespace Front\Traits;

use Common\Config\SessionConfig;

trait LoginAuthTrait
{
    protected $wechatUser = [];
    protected $userId = 0;

    public function init()
    {
        $this->wechatUser = session(SessionConfig::FRONT_USER_INFO);
        $this->userId = session(SessionConfig::FRONT_USER_ID);
    }
}
