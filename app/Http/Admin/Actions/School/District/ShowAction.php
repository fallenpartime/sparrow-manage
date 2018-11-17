<?php
/**
 *
 * Date: 2018/10/7
 * Time: 21:47
 */
namespace App\Http\Admin\Actions\School\District;

use Admin\Actions\BaseAction;
use Admin\Models\School\SchoolDistrict;
use Admin\Services\Log\LogService;
use Admin\Services\School\Processor\SchoolDistrictProcessor;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class ShowAction extends BaseAction
{
    use ApiActionTrait;

    protected $_district = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_district = SchoolDistrict::find($id);
        }
        if (empty($this->_district)) {
            $this->errorJson(500, '学区不存在');
        }
        $this->process();
    }

    protected function process()
    {
        $showValue = $this->_district->is_show;
        $showValue = ($showValue + 1) % 2;
        LogService::operateLog($this->request, 72, $this->_district->id, "学区显示状态修改：{$this->_district->is_show}=>{$showValue}", $this->getAuthService()->getAdminInfo());
        $res = (new SchoolDistrictProcessor())->update($this->_district->id, ['is_show'=>$showValue]);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}
