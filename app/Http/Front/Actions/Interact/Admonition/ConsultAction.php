<?php
/**
 * 互动提交
 * Date: 2018/10/30
 * Time: 0:55
 */
namespace App\Http\Front\Actions\Interact\Admonition;

use Admin\Services\User\Processor\UserAdmonitionProcessor;
use Admin\Traits\ApiActionTrait;
use Front\Actions\BaseAction;
use Wechat\Traits\WechatDefaultOauthTrait;

class ConsultAction extends BaseAction
{
    use WechatDefaultOauthTrait, ApiActionTrait;

    public function run()
    {
        $this->init();
        if ($this->request->isMethod('post')) {
            $this->process();
        }
        $redirectUrl = route('front.admonition.feedback');
        $result = [
            'submit_url'    =>  route('front.admonition.consult'),
            'redirectUrl'   =>  $redirectUrl,
        ];
        return view('front.interact.admonition.consult', $result);
    }

    protected function process()
    {
        $name = trim(request('name'));
        $phone = trim(request('phone'));
        $idea = trim(request('idea'));
        if (empty($name) || empty($phone) || empty($idea)) {
            $this->errorJson(500, '请完整填写');
        }
        $data = [
            'user_id'   =>  $this->userId,
            'name'      =>  !empty($name)? $name: '',
            'phone'     =>  !empty($phone)? $phone: '',
            'content'   =>  !empty($idea)? $idea: '',
        ];
        (new UserAdmonitionProcessor())->insert($data);
        $this->successJson();
    }
}