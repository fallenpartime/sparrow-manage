<?php
/**
 * 活动作废
 * Date: 2018/10/20
 * Time: 21:57
 */
namespace App\Http\Admin\Actions\Activity\Operate\Question;

use Admin\Actions\BaseAction;
use Admin\Models\Activity\ActivityQuestion;
use Admin\Services\Activity\Processor\ActivityQuestionProcessor;
use Admin\Services\Log\LogService;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class RemoveAction extends BaseAction
{
    use ApiActionTrait;

    protected $_question = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_question = ActivityQuestion::find($id);
        }
        if (empty($this->_question)) {
            $this->errorJson(500, '问题不存在');
        }
        $this->process();
    }

    protected function process()
    {
        LogService::operateLog($this->request, 42, $this->_question->id, '作废问题', $this->getAuthService()->getAdminInfo());
        $res = (new ActivityQuestionProcessor())->destroy($this->_question->id);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}
