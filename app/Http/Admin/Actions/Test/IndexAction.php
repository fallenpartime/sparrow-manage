<?php
/**
 *
 * Date: 2018/10/2
 * Time: 23:53
 */
namespace App\Http\Admin\Actions\Test;

use Admin\Actions\BaseAction;
use Admin\Models\Article\Article;
use Frameworks\Tool\Random\HashTool;
use Illuminate\Support\Facades\Redis;
use Vinkla\Hashids\Facades\Hashids;
use Wechat\Traits\WechatDefaultOauthTrait;

class IndexAction extends BaseAction
{
    use WechatDefaultOauthTrait;

    public function run()
    {
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
