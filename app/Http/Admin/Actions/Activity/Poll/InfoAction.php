<?php
/**
 * 网络投票活动详情
 * Date: 2018/10/20
 * Time: 22:18
 */
namespace App\Http\Admin\Actions\Activity\Poll;

use Admin\Actions\BaseAction;
use Admin\Models\Activity\Activity;
use Admin\Services\Activity\ActivityService;
use Admin\Services\Activity\Processor\ActivityPictureProcessor;
use Admin\Services\Activity\Processor\ActivityProcessor;
use Admin\Services\Log\LogService;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class InfoAction extends BaseAction
{
    use ApiActionTrait;

    protected $_activity = null;
    protected $_type = 1;
    protected $pictureProcessor = null;

    protected function getPictureProcessor()
    {
        if (empty($this->pictureProcessor)) {
            $this->pictureProcessor = new ActivityPictureProcessor();
        }
        return $this->pictureProcessor;
    }

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $workNo = $httpTool->getBothSafeParam('work_no', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_activity = Activity::find($id);
        }
        if ($workNo == 1 || $workNo == 2) {
            if ($workNo == 1) {
                return $this->showInfo();
            } else {
                $this->process();
            }
        }
        $this->errorJson(500, '请求类型不匹配');
    }

    protected function showInfo()
    {
        $result = [
            'record'            =>  $this->_activity,
            'articleType'       =>  1,
            'menu'              => ['activityCenter', 'pollManage', 'activityPollInfo'],
            'actionUrl'         => route('activityPollInfo', ['work_no'=>2]),
        ];
        return $this->createView('admin.activity.poll.info', $result);
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $title = $httpTool->getBothSafeParam('title');
        $author = $httpTool->getBothSafeParam('author');
        $description = $httpTool->getBothSafeParam('description');
        $content = request('content');
        $thankContent = $httpTool->getBothSafeParam('thank_content');
        $publishedAt = $httpTool->getBothSafeParam('pubdate');
        $picPreview = $this->request->get('list_pic_preview');
        $title = trim($title);
        $author = trim($author);
        $description = trim($description);
        $publishedAt = trim($publishedAt);
        if(empty($title)){
            $this->errorJson(500, '标题不能为空');
        }
        if(empty($description)){
            $this->errorJson(500, '描述不能为空');
        }
        if(empty($content)){
            $this->errorJson(500, '内容不能为空');
        }
        if (!empty($id) && empty($this->_activity)) {
            $this->errorJson(500, '活动不存在');
        }
        if (!empty($this->_activity)) {
            if ($this->_activity->is_show || $this->_activity->is_open) {
                if (empty($author)) {
                    $this->errorJson(500, '活动作者不能为空');
                }
                if (empty($publishedAt)) {
                    $this->errorJson(500, '活动发布时间不能为空');
                }
            }
        }
        $data = [
            'type'      =>  $this->_type,
            'title'     =>  $title,
            'author'    =>  $author,
            'description'   =>  $description,
            'content'   =>  $content,
            'thank_content' =>  !empty($thankContent)? $thankContent: '',
            'published_at'  =>  !empty($publishedAt)? $publishedAt: null,
            'list_pic'      =>  !empty($picPreview)?  $picPreview[0]: null,
        ];
        $res = empty($this->_activity)? $this->save($data): $this->update($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function clearImage($activityId)
    {
        if ($activityId > 0) {
            $this->getPictureProcessor()->remove(['activity_id'=>$activityId, 'type'=>1]);
        }
    }

    protected function processImage($imageUrl, $activityId, $create = 0)
    {
        $imageUrl = trim($imageUrl);
        if ($activityId <= 0) {
            return false;
        }
        if (!empty($imageUrl)) {
            $data = [
                'activity_id'   =>  $activityId,
                'type'          =>  1,
                'pic'           =>  $imageUrl,
            ];
        }
        if ($create == 1) {
            $this->clearImage($activityId);
            if (!empty($data)) {
                list($status, $picture) = $this->getPictureProcessor()->insert($data);
                return $status;
            }
        } else {
            if (empty($imageUrl)) {
                $this->clearImage($activityId);
            } else if($imageUrl != $this->_activity->list_pic) {
                $this->clearImage($activityId);
                if (!empty($data)) {
                    list($status, $picture) = $this->getPictureProcessor()->insert($data);
                    return $status;
                }
            }
        }
        return false;
    }

    protected function processCache($id, $data)
    {
        $service = new ActivityService($id);
        $service->setCacheRecord($data);
    }

    protected function save($data)
    {
        $processor = new ActivityProcessor();
        list($status, $activity) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '活动创建失败');
        }
        LogService::operateLog($this->request, 20, $activity->id, "添加活动", $this->getAuthService()->getAdminInfo());
        $data['id'] = $activity->id;
        $data['is_show'] = 0;
        $data['is_open'] = 0;
        $data['read_count'] = 0;
        $data['like_count'] = 0;
        $data['join_count'] = 0;
        $data['overed_at'] = '';
        $this->processCache($activity->id, $data);
        $this->processImage($data['list_pic'], $activity->id, 1);
        $this->successJson();
    }

    protected function update($data)
    {
        if ($this->_activity->type != $this->_type) {
            $this->errorJson(500, '活动类别非网络投票');
        }
        LogService::operateLog($this->request, 21, $this->_activity->id, "编辑活动", $this->getAuthService()->getAdminInfo());
        $processor = new ActivityProcessor();
        list($status, $id) = $processor->update($this->_activity->id, $data);
        if (empty($status)) {
            $this->errorJson(500, '活动修改失败');
        }
        $this->processCache($this->_activity->id, $data);
        $this->processImage($data['list_pic'], $id);
        $this->successJson();
    }
}
