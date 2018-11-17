<?php
/**
 * 用户意见回馈
 * Date: 2018/11/3
 * Time: 13:55
 */
namespace App\Http\Front\Actions\Interact\Admonition;

use Front\Actions\BaseAction;

class FeedbackAction extends BaseAction
{
    public function run()
    {
        $redirectUrl = route('front.admonitions');
        return view('front.interact.admonition.feedback', ['redirectUrl'=>$redirectUrl]);
    }
}