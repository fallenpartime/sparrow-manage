<?php
/**
 * 网络投票活动详情
 * Date: 2018/10/20
 * Time: 22:18
 */
namespace App\Http\Admin\Actions\Activity\Poll\Question;

use Admin\Actions\BaseAction;
use Admin\Models\Activity\Activity;
use Admin\Models\Activity\ActivityAnswer;
use Admin\Models\Activity\ActivityQuestion;
use Admin\Services\Activity\Processor\ActivityAnswerProcessor;
use Admin\Services\Activity\Processor\ActivityQuestionProcessor;
use Admin\Services\Log\LogService;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class InfoAction extends BaseAction
{
    use ApiActionTrait;

    protected $_question = null;
    protected $_activity = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $workNo = $httpTool->getBothSafeParam('work_no', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_question = ActivityQuestion::find($id);
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
        $httpTool = $this->getHttpTool();
        $activityId = $httpTool->getBothSafeParam('activity_id', HttpConfig::PARAM_NUMBER_TYPE);
        $answers = null;
        if (!empty($this->_question)) {
            $answers = $this->_question->answers;
            $this->_activity = Activity::find($this->_question->activity_id);
        } else {
            $this->_activity = Activity::find($activityId);
        }
        $allowEditAnswer = 1;
        if (!empty($this->_activity) && $this->_activity->is_open) {
            $allowEditAnswer = 0;
        }

        $result = [
            'record'            =>  $this->_question,
            'answers'           =>  $answers,
            'activityId'        =>  !empty($this->_question)? $this->_question->activity_id: $activityId,
            'articleType'       =>  1,
            'allowEditAnswer'   =>  $allowEditAnswer,
            'menu'              => ['activityCenter', 'pollManage', 'activityPollQuestionInfo'],
            'actionUrl'         => route('activityPollQuestionInfo', ['work_no'=>2]),
            'redirectUrl'       => route('activityPollQuestions'),
        ];
        return $this->createView('admin.activity.poll.question.info', $result);
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $activityId = $httpTool->getBothSafeParam('activity_id', HttpConfig::PARAM_NUMBER_TYPE);
        $isCheckbox = $httpTool->getBothSafeParam('is_checkbox', HttpConfig::PARAM_NUMBER_TYPE);
        $type = $httpTool->getBothSafeParam('type', HttpConfig::PARAM_NUMBER_TYPE);
        $title = $httpTool->getBothSafeParam('title');
        $picPreview = $this->request->get('list_pic_preview');
        $source = !empty($picPreview)?  $picPreview[0]: '';
        $title = trim($title);
        if (empty($activityId)) {
            $this->errorJson(500, '活动ID不能为空');
        }
        if (!empty($this->_question) && $this->_question->activity_id != $activityId) {
            $this->errorJson(500, '活动ID不一致');
        }
        $this->_activity = Activity::find($activityId);
        if (empty($this->_activity)) {
            $this->errorJson(500, '活动不存在');
        }
        if (empty($title) && empty($source)) {
            $this->errorJson(500, '标题与图片不能同时为空');
        }
        if (!empty($id) && empty($this->_question)) {
            $this->errorJson(500, '问题不存在');
        }
        $data = [
            'activity_id'   =>  $activityId,
            'type'      =>  $type,
            'title'     =>  $title,
            'source'    =>  $source,
            'is_checkbox'   =>  !empty($isCheckbox)? $isCheckbox: 0,
        ];
        $res = empty($this->_question)? $this->save($data): $this->update($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function save($data)
    {
        $processor = new ActivityQuestionProcessor();
        list($status, $question) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '问题创建失败');
        }
        $this->processAnswer($question->id);
        LogService::operateLog($this->request, 40, $question->id, '添加问题', $this->getAuthService()->getAdminInfo());
        $this->successJson();
    }

    protected function update($data)
    {
        LogService::operateLog($this->request, 41, $this->_question->id, '编辑问题', $this->getAuthService()->getAdminInfo());
        $processor = new ActivityQuestionProcessor();
        list($status, $id) = $processor->update($this->_question->id, $data);
        if (empty($status)) {
            $this->errorJson(500, '问题修改失败');
        }
        $this->processAnswer($id);
        $this->successJson();
    }

    protected function processAnswer($questionId)
    {
        $activityId = $this->_activity->id;
        if (empty($activityId)) {
            return false;
        }
        // 活动进行中、已结束不能更改
        if ($this->_activity->is_open) {
            return false;
        }
        $processor = new ActivityAnswerProcessor();
        $answerIds = $this->request->get('answer_id');
        ActivityAnswer::where('question_id', $questionId)->delete();
        $answerTitles = $this->request->get('answer_title');
        foreach ($answerIds as $key => $answerId) {
            $answerTitle = trim($answerTitles[$key]);
            if (empty($answerTitle)) {
                continue;
            }
            if (!empty($answerId)) {
                $record = ActivityAnswer::withTrashed()->find($answerId);
                $record->restore();
                $record->title = $answerTitle;
                $record->save();
            } else {
                $data = [
                    'activity_id'  =>  $activityId,
                    'question_id'  =>  $questionId,
                    'title'        =>  $answerTitle,
                ];
                $processor->insert($data);
            }
        }
    }
}
