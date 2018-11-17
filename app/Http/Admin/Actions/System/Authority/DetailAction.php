<?php
/**
 * 权限详情
 * Date: 2018/10/3
 * Time: 22:53
 */
namespace App\Http\Admin\Actions\System\Authority;

use Admin\Actions\BaseAction;
use Admin\Models\System\AdminAction;
use Admin\Services\Authority\AuthorityService;
use Admin\Services\Authority\Processor\AdminActionProcessor;
use Admin\Services\Log\LogService;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class DetailAction extends BaseAction
{
    use ApiActionTrait;

    protected $authority = [];

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $workNo = $httpTool->getBothSafeParam('work_no', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->authority = (new AdminActionProcessor())->getSingleById($id);
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
        list($firstId, $secondId) = $this->getParentId($this->authority);
        $authorityService = new AuthorityService();
        $result = [
            'record'        => $this->authority,
            'relate_menu'   => $authorityService->relateMenu([1,2]),
            'first_menu'    => $firstId,
            'second_menu'   => $secondId,
            'menu'  =>  ['manageCenter', 'authorityManage', 'authorityInfo'],
            'actionUrl'     => route('authorityInfo', ['work_no'=>2]),
            'redirectUrl'   => route('authorities'),
        ];
        return $this->createView('admin.system.authority.detail', $result);
    }

    private function getParentId($authorization)
    {
        $firstId = $secondId = 0;
        if (!empty($authorization)) {
            $parentId = $authorization->parent_id;
            $type = $authorization->type;
            if($type == 2){
                $firstId = $parentId;
            }else if($type == 3){
                $parentAuth = AdminAction::find($parentId);
                if (!empty($parentAuth) && $parentAuth->type == 2) {
                    $secondId = $parentId;
                    $parentAuth = AdminAction::find($parentAuth->parent_id);
                    if (!empty($parentAuth) && $parentAuth->type == 1) {
                        $firstId = $parentAuth->id;
                    }
                }
            }
        }
        return [$firstId, $secondId];
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $first_id = $httpTool->getBothSafeParam('first_menu', HttpConfig::PARAM_NUMBER_TYPE);
        $second_id = $httpTool->getBothSafeParam('second_menu', HttpConfig::PARAM_NUMBER_TYPE);
        $second_id = !empty($first_id)? $second_id: 0;
        $tsName = $httpTool->getBothSafeParam('ts_name');
        $tsAction = trim($_REQUEST['ts_action']);
        $type = $httpTool->getBothSafeParam('type', HttpConfig::PARAM_NUMBER_TYPE);
        $record = $this->authority;
        if (!empty($id)) {
            if (empty($record)) {
                $this->errorJson(500, '修改权限不存在');
            }
        }
        if (empty($tsName) || empty($tsAction) || empty($type)) {
            $this->errorJson(500, '缺少权限主要信息');
        }
        if ($first_id) {
            if ($second_id) {
                if ($type != 3) {
                    $this->errorJson(500, '请选择操作权限');
                }
            } else {
                if ($type != 2) {
                    $this->errorJson(500, '请选择二级权限');
                }
            }
        } elseif ($type != 1) {
            $this->errorJson(500, '请选择一级权限');
        }
        if($second_id){
            $parent_id = $second_id;
        }else{
            $parent_id = $first_id? $first_id: 0;
        }

        $data = [
            'parent_id' =>  $parent_id,
            'type'      =>  $type,
            'ts_action' =>  $tsAction,
            'name'      =>  $tsName,
        ];
        list($res, $id) = empty($id)? $this->store($data): $this->update($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function store($data)
    {
        $processor = new AdminActionProcessor();
        $actionRecord = $processor->getSingleByAction($data['ts_action']);
        if (!empty($actionRecord)) {
            $this->errorJson(500, '权限标示已存在');
        }
        $nameRecord = $processor->getSingleByName($data['name']);
        if (!empty($nameRecord)) {
            $this->errorJson(500, '权限名已存在');
        }
        list($res, $model) = $processor->insert($data);
        LogService::adminLog($this->request, 10, $model->id, '添加权限', $this->getAuthService()->getAdminInfo());
        $insertId = $res? $model->id: 0;
        return [$res, $insertId];
    }

    protected function update($data)
    {
        $processor = new AdminActionProcessor();
        $actionRecord = $processor->getSingleByAction($data['ts_action']);
        if (!empty($actionRecord) && $actionRecord->id != $this->authority->id) {
            $this->errorJson(500, '权限标示已存在');
        }
        $nameRecord = $processor->getSingleByName($data['name']);
        if (!empty($nameRecord) && $actionRecord->id != $this->authority->id) {
            $this->errorJson(500, '权限名已存在');
        }
        LogService::adminLog($this->request, 11, $this->authority->id, '编辑权限', $this->getAuthService()->getAdminInfo());
        return $processor->update($this->authority->id, $data);
    }
}