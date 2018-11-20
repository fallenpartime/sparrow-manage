<?php
/**
 *
 * Date: 2018/10/2
 * Time: 23:53
 */
namespace App\Http\Admin\Actions\Test;

use Admin\Action\BaseAction;
use Common\Models\Article\Article;
use Frameworks\Tool\Random\HashTool;
use Illuminate\Support\Facades\Redis;
use Vinkla\Hashids\Facades\Hashids;
use Wechat\Traits\WechatDefaultOauthTrait;
use Overtrue\Socialite\User as SocialiteUser;

class IndexAction extends BaseAction
{
    use WechatDefaultOauthTrait;

    public function run()
    {
        dd($this->request->getUri());
//        $sessionKey = 'wechat.oauth_user.default';
//        var_dump(session($sessionKey));

//        $user = new SocialiteUser([
//            'id' => time(),
//            'name' => 'name_'.time(),
//            'nickname' => 'nickname_'.time(),
//            'avatar' => '/storage/20181105/bgnOSAvr0oozKHnvjs32aQNNsRTpOSqtsjUZsVse.jpeg',
//            'email' => null,
//            'original' => [],
//            'provider' => 'WeChat',
//        ]);

//        Redis::flushall();
//        $this->init();
//        $hashTool = new HashTool();
//        $hash = $hashTool->encode(1,2);
//        var_dump($hash);
//        $hashCode = $hashTool->decode($hash);
//        dd($hashCode);

//        dd(Article::find(1)->increment('read_count'));
//        $keyname = 'edu:test:name';
////        Redis::set($keyname, time());
//        dd(Redis::keys("*"));
//        $result = [
//            'menu'  =>  ['manageCenter', 'authorityCenter', 'authorities']
//        ];
//        return $this->createView('admin.test.index', $result);
    }
}
