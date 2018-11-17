<?php
/**
 * 学区列表
 * Date: 2018/10/7
 * Time: 10:57
 */
namespace App\Http\Admin\Actions\School\School;

use Admin\Actions\BaseAction;
use Admin\Config\SchoolConfig;
use Admin\Models\School\School;
use Admin\Models\School\SchoolDistrict;
use Admin\Services\Common\CommonService;
use Admin\Services\Sql\School\SchoolSqlProcessor;

class IndexAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route('schools');
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new SchoolSqlProcessor())->getListSql(new School(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with('district')->select(['id', 'type', 'no', 'district_no', 'name', 'address', 'is_show', 'telent', 'property', 'created_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonService::pagination($total, $pageSize, $page, $url);
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'          => ['schoolCenter', 'schoolManage', 'schools'],
            'properties'    => SchoolConfig::getPropertyList(),
            'districts'     => SchoolDistrict::all(['id', 'no', 'name']),
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route('schools'),
        ];
        return $this->createView('admin.school.school.index', $result);
    }

    protected function allowOperate()
    {
        $operateList = [
            'change_show' => 0
        ];
        $operateUrl = [
            'change_url' => ''
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('schoolShow')) {
            $operateList['change_show'] = 1;
            $operateUrl['change_url'] = route('schoolShow');
        }
        return [$operateList, $operateUrl];
    }

    protected function listAllowOperate($list, $key)
    {
        $operateList = [
            'allow_operate_edit' => 0,
            'allow_operate_change' => 0
        ];
        $list[$key]->allow_operate_change = 0;
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('schoolInfo')) {
            $operateList['allow_operate_edit'] = 1;
        }
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('schoolShow')) {
            $operateList['allow_operate_change'] = 1;
        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }

    protected function processList($list)
    {
        foreach ($list as $key => $item) {
            $list[$key]->edit_url = route('schoolInfo', ['work_no'=>1, 'id'=>$item->id]);
            $list = $this->listAllowOperate($list, $key);
        }
        return $list;
    }
}
