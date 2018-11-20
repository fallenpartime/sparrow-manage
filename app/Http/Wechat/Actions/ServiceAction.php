<?php
/**
 * Wechat service
 * Date: 2018/11/5
 * Time: 8:44
 */
namespace App\Http\Wechat\Actions;

use EasyWeChat\Kernel\Exceptions\BadRequestException;
use Wechat\Action\BaseAction;
use Wechat\Tool\WechatTool;

class ServiceAction extends BaseAction
{
    public function run()
    {
        $wechatTool = new WechatTool();
        if (isset($_GET['echostr'])) {
            try {
                if ($wechatTool->valid()) {
                    header('content-type:text');
                    echo $_GET["echostr"];
                }
                exit();
            } catch (BadRequestException $exception) {
                echo $exception->getMessage();
                exit();
            }
        }
        $app = $wechatTool->getApp();
        $wechatTool->setMessageHandler(function ($message) use ($app) {
            $userOpenId = $message->FromUserName;
            if ($message->MsgType=='event') {
                if ($message->Event == 'subscribe') {
                    // 关注公众号
                    $userUnionId = $message->ToUserName;
                    $userService = $app->user;
                } else if ($message->Event == 'unsubscribe') {
                    // 取消关注公众号
                }
            }
        });
        return $wechatTool->serve();
        $app = app('wechat.official_account');
        $app->server->setMessageHandler(function($message) use ($app){
            if ($message->MsgType=='event') {
                $user_openid = $message->FromUserName;
                if ($message->Event == 'subscribe') {
                    //下面是你点击关注时，进行的操作
                    $user_info['unionid'] = $message->ToUserName;
                    $user_info['openid'] = $user_openid;
                    $userService = $app->user;
                    $user = $userService->get($user_info['openid']);
                    $user_info['subscribe_time'] = $user['subscribe_time'];
                    $user_info['nickname'] = $user['nickname'];
                    $user_info['avatar'] = $user['headimgurl'];
                    $user_info['sex'] = $user['sex'];
                    $user_info['province'] = $user['province'];
                    $user_info['city'] = $user['city'];
                    $user_info['country'] = $user['country'];
                    $user_info['is_subscribe'] = 1;
//                    if (WxStudent::weixin_attention($user_info)) {
//                        return '欢迎关注';
//                    } else {
//                        return '您的信息由于某种原因没有保存，请重新关注';
//                    }
                } else if ($message->Event == 'unsubscribe') {
//                    if (WxStudent::weixin_cancel_attention($user_openid)) {
//                        return '已取消关注';
//                    }
                }
            }
        });
        $app->server->push(function($message){
            return "欢迎！";
        });

        return $app->server->serve();
    }
}
