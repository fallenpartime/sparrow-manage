<?php
/**
 * Wechat service
 * Date: 2018/11/5
 * Time: 8:44
 */
namespace App\Http\Wechat\Actions;

use Wechat\Actions\BaseAction;

class ServiceAction extends BaseAction
{
    public function run()
    {
        $app = app('wechat.official_account');
        $app->server->push(function($message){
            return "欢迎关注 overtrue！";
        });

        return $app->server->serve();
    }
}
