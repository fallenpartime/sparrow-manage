<?php
/**
 * 获取微信用户信息
 * Date: 2018/11/18
 * Time: 19:32
 */
namespace Wechat\Services\User\Integration;

use Frameworks\Services\Basic\Processor\BaseWorkProcessor;
use Wechat\Tool\WechatTool;

class WechatUserInfoIntegration extends BaseWorkProcessor
{
    protected $openId = '';
    protected $wechat = null;

    public function __construct($openId, $account = '')
    {
        $this->_init($openId, $account);
    }

    public function _init($openId, $account = '')
    {
        $this->openId = $openId;
        $this->wechat = new WechatTool($account);
        return $this;
    }

    public function process()
    {
        $openId = $this->openId;
        if (empty($openId)) {
            return $this->parseResult('缺少openid', []);
        }
        $user = $this->wechat->getUserInfo($openId);
        if (empty($user)) {
            return $this->parseResult('用户信息未找到', []);
        }
        $this->status = 1;
        return $this->parseResult('', $user);
    }
}