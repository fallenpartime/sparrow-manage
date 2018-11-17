<?php
/**
 * 学区详情
 * Date: 2018/10/7
 * Time: 10:58
 */
namespace App\Http\Admin\Actions\School\District;

use Admin\Action\BaseAction;
use Common\Models\School\SchoolDistrict;
use Admin\Services\Log\LogService;
use Admin\Services\School\Processor\SchoolDistrictProcessor;
use Frameworks\Traits\ApiActionTrait;
use Frameworks\Tool\Http\Config\HttpConfig;

class DetailAction extends BaseAction
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
        if ($httpTool->isAjax()) {
            $this->process();
        }
        return $this->showInfo();
    }

    protected function showInfo()
    {
        $result = [
            'record'            =>  $this->_district,
            'menu'  =>  ['schoolCenter', 'districtManage', 'districtInfo'],
            'actionUrl'         => route('districtInfo'),
            'redirectUrl'       => route('districts'),
        ];
        return $this->createView('admin.school.district.detail', $result);
    }

    protected function validateRepeat(SchoolDistrictProcessor $processor, $data, $isUpdate = 0)
    {
        $record = $processor->getSingleByNo($data['no']);
        if (!empty($record)) {
            if ($isUpdate) {
                if ($record->id != $this->_district->id) {
                    $this->errorJson(500, '学区编号已存在');
                }
            } else {
                $this->errorJson(500, '学区编号已存在');
            }
        }
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $name = $httpTool->getBothSafeParam('name');
        $no = $httpTool->getBothSafeParam('no');
        $name = trim($name);
        $no = trim($no);
        if(empty($name)){
            $this->errorJson(500, '学区名为空');
        }
        if(empty($no)){
            $this->errorJson(500, '学区编号为空');
        }
        if (!empty($id) && empty($this->_district)) {
            $this->errorJson(500, '记录不存在');
        }
        $data = [
            'name'  =>  $name,
            'no'    =>  $no,
        ];
        $res = empty($this->_district)? $this->save($data): $this->update($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function save($data)
    {
        $processor = new SchoolDistrictProcessor();
        $this->validateRepeat($processor, $data);
        list($status, $district) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '学区创建失败');
        }
        LogService::operateLog($this->request, 60, $district->id, '添加学区', $this->getAuthService()->getAdminInfo());
        $this->successJson();
    }

    protected function update($data)
    {
        LogService::operateLog($this->request, 60, $this->_district->id, '编辑学区', $this->getAuthService()->getAdminInfo());
        $processor = new SchoolDistrictProcessor();
        $this->validateRepeat($processor, $data, 1);
        $processor->update($this->_district->id, $data);
        $this->successJson();
    }
}
