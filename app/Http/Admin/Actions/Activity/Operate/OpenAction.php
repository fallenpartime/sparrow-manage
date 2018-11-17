<?php
/**
 * 活动开启状态修改
 * Date: 2018/10/20
 * Time: 21:57
 */
namespace App\Http\Admin\Actions\Activity\Operate;

use Admin\Actions\BaseAction;
use Admin\Config\ActivityConfig;
use Admin\Models\Activity\Activity;
use Admin\Services\Activity\ActivityService;
use Admin\Services\Activity\Processor\ActivityProcessor;
use Admin\Services\Log\LogService;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;
use Illuminate\Support\Facades\Redis;

class OpenAction extends BaseAction
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
        if (empty($this->_activity->published_at)) {
            $this->errorJson(500, '活动发布时间不能为空');
        }
        if (empty($this->_activity->author)) {
            $this->errorJson(500, '活动作者不能为空');
        }
        $this->process();
    }

    protected function process()
    {
        $openValue = $this->_activity->is_open;
        if ($openValue == 0) {
            $this->open();
        }
        if ($openValue == 1) {
            $this->close();
        }
        $this->errorJson(500, '操作类型错误');
    }

    protected function open()
    {
        $data = ['is_open'=>1, 'opened_at'=>date('Y-m-d H:i:s')];
        LogService::operateLog($this->request, 22, $this->_activity->id, "活动开放状态修改：0=>1", $this->getAuthService()->getAdminInfo());
        $res = (new ActivityProcessor())->update($this->_activity->id, $data);
        if ($res) {
            // 活动缓存开启状态修改
            $articleService = new ActivityService($this->_activity->id);
            $articleService->setCacheRecord($data);
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function close()
    {
        $data = ['overed_at'=>date('Y-m-d H:i:s')];
        LogService::operateLog($this->request, 22, $this->_activity->id, "活动开放状态修改：1=>0", $this->getAuthService()->getAdminInfo());
        $res = (new ActivityProcessor())->update($this->_activity->id, $data);
        if ($res) {
            $voteKey = ActivityConfig::VOTE_PREFIX.array_get($this->_activity, 'id');
            Redis::del($voteKey);
            $articleService = new ActivityService($this->_activity->id);
            $articleService->setCacheRecord($data);
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}
