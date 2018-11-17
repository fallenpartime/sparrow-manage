<?php
/**
 * 学区详情
 * Date: 2018/10/7
 * Time: 10:58
 */
namespace App\Http\Admin\Actions\School\School;

use Admin\Actions\BaseAction;
use Admin\Config\SchoolConfig;
use Admin\Models\School\School;
use Admin\Models\School\SchoolDistrict;
use Admin\Services\Log\LogService;
use Admin\Services\School\Processor\SchoolProcessor;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class DetailAction extends BaseAction
{
    use ApiActionTrait;

    protected $_school = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $workNo = $httpTool->getBothSafeParam('work_no', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_school = School::find($id);
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
            'record'            =>  $this->_school,
            'districts'         =>  SchoolDistrict::all(['id', 'no', 'name']),
            'menu'  =>  ['schoolCenter', 'schoolManage', 'schoolInfo'],
            'properties'        => SchoolConfig::getPropertyList(),
            'actionUrl'         => route('schoolInfo', ['work_no'=>2]),
            'redirectUrl'       => route('schools'),
        ];
        return $this->createView('admin.school.school.detail', $result);
    }

    protected function validateRepeat(SchoolProcessor $processor, $data, $isUpdate = 0)
    {
        $record = $processor->getSingleByNo($data['no']);
        if (!empty($record)) {
            if ($isUpdate) {
                if ($record->id != $this->_school->id) {
                    $this->errorJson(500, '学校编号已存在');
                }
            } else {
                $this->errorJson(500, '学校编号已存在');
            }
        }
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $name = $httpTool->getBothSafeParam('name');
        $no = $httpTool->getBothSafeParam('no');
        $address = $httpTool->getBothSafeParam('address');
        $districtNo = $httpTool->getBothSafeParam('district_no');
        $property = $httpTool->getBothSafeParam('property', HttpConfig::PARAM_NUMBER_TYPE);
        $telent = $httpTool->getBothSafeParam('telent');
        $name = trim($name);
        $no = trim($no);
        $address = trim($address);
        $districtNo = trim($districtNo);
        $telent = trim($telent);
        $property = intval($property);
        if(empty($name)){
            $this->errorJson(500, '学校名为空');
        }
        if(empty($no)){
            $this->errorJson(500, '学校编号为空');
        }
        if(empty($address)){
            $this->errorJson(500, '学校地址为空');
        }
        if (!empty($id) && empty($this->_school)) {
            $this->errorJson(500, '记录不存在');
        }
        $data = [
            'name'  =>  $name,
            'no'    =>  $no,
            'address'       =>  $address,
            'property'      =>  $property,
            'telent'        =>  $telent,
        ];
        if (!empty($districtNo)) {
            $data['district_no'] = $districtNo;
        }
        $res = empty($this->_school)? $this->save($data): $this->update($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function save($data)
    {
        $processor = new SchoolProcessor();
        $this->validateRepeat($processor, $data);
        list($status, $school) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '学校创建失败');
        }
        LogService::operateLog($this->request, 60, $school->id, '添加学校', $this->getAuthService()->getAdminInfo());
        $this->successJson();
    }

    protected function update($data)
    {
        LogService::operateLog($this->request, 61, $this->_school->id, '编辑学校', $this->getAuthService()->getAdminInfo());
        $processor = new SchoolProcessor();
        $this->validateRepeat($processor, $data, 1);
        $processor->update($this->_school->id, $data);
        $this->successJson();
    }
}
