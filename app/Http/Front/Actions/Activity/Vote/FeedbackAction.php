<?php
/**
 * 用户意见回馈
 * Date: 2018/11/3
 * Time: 13:55
 */
namespace App\Http\Front\Actions\Activity\Vote;

use Front\Actions\BaseAction;
use Front\Traits\ActivityActionTrait;
use Front\Traits\ErrorActionTrait;

class FeedbackAction extends BaseAction
{
    use ActivityActionTrait, ErrorActionTrait;

    public function run()
    {
        if (!$this->initRecordByCode()) {
            return $this->errorActivityRedirect('活动不见啦');
        }
        $redirectUrl = $this->getService()->getShowUrl(array_get($this->record, 'type'));
        $result = [
            'content'       =>  array_get($this->record, 'thank_content'),
            'redirectUrl'   =>  $redirectUrl,
        ];
        return view('front.activity.vote.feedback', $result);
    }
}