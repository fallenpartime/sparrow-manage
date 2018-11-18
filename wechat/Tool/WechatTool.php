<?php
/**
 *
 * Date: 2018/11/16
 * Time: 23:21
 */
namespace Wechat\Tool;

use Wechat\Config\WechatConfig;

class WechatTool
{
    protected $wechatApp = null;

    public function __construct($account = '')
    {
        $account = !empty($account)? $account: WechatConfig::DEFAULT_OFFICIAL_ACCOUNT;
        $this->wechatApp = app($account);
    }

    public function getApp()
    {
        return $this->wechatApp;
    }

    public function getUserInfo($openId)
    {
        return $this->wechatApp->user->get($openId);
    }

    public function pushTextMessage($message)
    {
        $this->wechatApp->server->push(function ($message) {
            return 'Welcome!!';
        });
    }

    public function setMessageHandler($func)
    {
        $this->wechatApp->server->setMessageHandler($func);
    }

    public function serve()
    {
        $this->wechatApp->server->serve();
    }
}