<?php
/**
 * 显示状态修改
 * Date: 2018/10/20
 * Time: 21:57
 */
namespace App\Http\Admin\Actions\Activity\Operate;

use Admin\Actions\BaseAction;
use Admin\Models\Activity\Activity;
use Admin\Services\Activity\ActivityService;
use Admin\Services\Activity\Processor\ActivityProcessor;
use Admin\Services\Log\LogService;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class ShowAction extends BaseAction
{
    use ApiActionTrait;

    protected $_activity = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_activity = Activity::find($id);
        }
        if (empty($this->_activity)) {
            $this->errorJson(500, '活动不存在');
        }
        $this->process();
    }

    protected function process()
    {
        $showValue = $this->_activity->is_show;
        $showValue = ($showValue + 1) % 2;
        if ($showValue == 1 && empty($this->_activity->published_at)) {
            $this->errorJson(500, '发布时间未设置，不可设置显示');
        }
        if ($showValue == 1) {
            if (empty($this->_activity->published_at)) {
                $this->errorJson(500, '活动发布时间不能为空');
            }
            if (empty($this->_activity->author)) {
                $this->errorJson(500, '活动作者不能为空');
            }
        }
        LogService::operateLog($this->request, 24, $this->_activity->id, "活动显示状态修改：{$this->_activity->is_show}=>{$showValue}", $this->getAuthService()->getAdminInfo());
        $res = (new ActivityProcessor())->update($this->_activity->id, ['is_show'=>$showValue]);
        if ($res) {
            // 活动缓存显示状态修改
            $articleService = new ActivityService($this->_activity->id);
            $articleService->setCacheRecord(['is_show'=>$showValue]);
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}
