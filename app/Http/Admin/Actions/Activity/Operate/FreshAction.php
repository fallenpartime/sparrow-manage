<?php
/**
 * 活动缓存刷新
 * Date: 2018/10/23
 * Time: 21:37
 */
namespace App\Http\Admin\Actions\Activity\Operate;

use Admin\Actions\BaseAction;
use Admin\Models\Activity\Activity;
use Admin\Services\Activity\ActivityService;
use Admin\Services\Log\LogService;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class FreshAction extends BaseAction
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
        $data = [
            'id'        =>  $this->_activity->id,
            'type'      =>  $this->_activity->type,
            'title'     =>  $this->_activity->title,
            'author'    =>  $this->_activity->author,
            'description'   =>  $this->_activity->description,
            'content'   =>  $this->_activity->content,
            'thank_content' =>  $this->_activity->thank_content,
            'is_show'       =>  $this->_activity->is_show,
            'is_open'       =>  $this->_activity->is_open,
            'list_pic'      =>  $this->_activity->list_pic,
            'read_count'    =>  $this->_activity->read_count,
            'like_count'    =>  $this->_activity->like_count,
            'join_count'    =>  $this->_activity->join_count,
            'published_at'  =>  $this->_activity->published_at,
            'opened_at'     =>  $this->_activity->opened_at,
            'overed_at'     =>  $this->_activity->overed_at,
        ];
        LogService::operateLog($this->request, 25, $this->_activity->id, "活动缓存刷新", $this->getAuthService()->getAdminInfo());
        $activityService = new ActivityService($this->_activity->id);
        $activityService->setCacheRecord($data);
        $this->successJson('');
    }
}
