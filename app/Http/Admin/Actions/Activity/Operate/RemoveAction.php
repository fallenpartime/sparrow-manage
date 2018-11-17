<?php
/**
 * 活动作废
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

class RemoveAction extends BaseAction
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
        LogService::operateLog($this->request, 23, $this->_activity->id, "活动作废", $this->getAuthService()->getAdminInfo());
        $res = (new ActivityProcessor())->destroy($this->_activity->id);
        if ($res) {
            // 作废活动缓存
            $articleService = new ActivityService($this->_activity->id);
            $articleService->removeCacheRecord();
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}
