<?php
/**
 *
 * Date: 2018/10/7
 * Time: 21:47
 */
namespace App\Http\Admin\Actions\School\School;

use Admin\Actions\BaseAction;
use Admin\Models\School\School;
use Admin\Services\Log\LogService;
use Admin\Services\School\Processor\SchoolProcessor;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class ShowAction extends BaseAction
{
    use ApiActionTrait;

    protected $_school = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_school = School::find($id);
        }
        if (empty($this->_school)) {
            $this->errorJson(500, '学校不存在');
        }
        $this->process();
    }

    protected function process()
    {
        $showValue = $this->_school->is_show;
        $showValue = ($showValue + 1) % 2;
        LogService::operateLog($this->request, 62, $this->_school->id, "学校显示状态修改：{$this->_school->is_show}=>{$showValue}", $this->getAuthService()->getAdminInfo());
        $res = (new SchoolProcessor())->update($this->_school->id, ['is_show'=>$showValue]);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}
