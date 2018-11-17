<?php
/**
 * 文章点赞
 * Date: 2018/10/30
 * Time: 1:17
 */
namespace App\Http\Front\Actions\Activity\Operate;

use Admin\Traits\ApiActionTrait;
use Front\Actions\BaseAction;
use Front\Traits\ActivityActionTrait;

class LikeAction extends BaseAction
{
    use ActivityActionTrait, ApiActionTrait;

    public function run()
    {
        if (!$this->initRecordByCode()) {
            $this->errorJson(500, '活动不见啦');
        }
        $count = $this->getService()->likeCounter();
        $data = [
            'count' =>  $count,
        ];
        $this->successJson('', $data);
    }
}
