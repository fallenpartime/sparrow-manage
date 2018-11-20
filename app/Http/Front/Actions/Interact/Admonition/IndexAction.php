<?php
/**
 * 师生交互
 * Date: 2018/10/29
 * Time: 23:19
 */
namespace App\Http\Front\Actions\Interact\Admonition;

use Common\Models\User\UserAdmonition;
use Front\Action\BaseAction;
use Front\Traits\LoginAuthTrait;

class IndexAction extends BaseAction
{
    use LoginAuthTrait;

    public function run()
    {
        $this->init();
        $list = UserAdmonition::where(['user_id'=>$this->userId, 'is_show'=>1])->select(['content', 'reply_content', 'created_at'])->get();
        $result = [
            'list'  =>  $list,
            'consult_url'   =>  route('front.admonition.consult')
        ];
        return view('front.interact.admonition.index', $result);
    }
}