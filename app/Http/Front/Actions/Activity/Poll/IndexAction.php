<?php
/**
 * 投票列表
 * Date: 2018/10/30
 * Time: 1:47
 */
namespace App\Http\Front\Actions\Activity\Poll;

use Admin\Traits\ApiActionTrait;
use Front\Actions\BaseAction;
use Front\Traits\Lists\ActivityActionTrait;

class IndexAction extends BaseAction
{
    use ActivityActionTrait, ApiActionTrait;

    protected $type = 1;

    public function run()
    {
        if ($this->isPost()) {
            $this->processList();
        }
        return $this->show();
    }

    protected function show()
    {
        return view('front.activity.poll.index', ['pull_url'=>route('front.polls')]);
    }
}
