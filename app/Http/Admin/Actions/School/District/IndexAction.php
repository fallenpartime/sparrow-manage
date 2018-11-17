<?php
/**
 * 学区列表
 * Date: 2018/10/7
 * Time: 10:57
 */
namespace App\Http\Admin\Actions\School\District;

use Admin\Actions\BaseAction;
use Admin\Models\School\SchoolDistrict;
use Admin\Services\Common\CommonService;
use Admin\Services\Sql\School\SchoolDistrictSqlProcessor;

class IndexAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route('districts');
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new SchoolDistrictSqlProcessor())->getListSql(new SchoolDistrict(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->select(['id', 'name', 'no', 'is_show', 'created_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonService::pagination($total, $pageSize, $page, $url);
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'          => ['schoolCenter', 'schoolDistrictManage', 'districts'],
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route('districts'),
        ];
        return $this->createView('admin.school.district.index', $result);
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
        if ($authService->isMaster || $authService->validateAction('districtShow')) {
            $operateList['change_show'] = 1;
            $operateUrl['change_url'] = route('districtShow');
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
        if ($authService->isMaster || $authService->validateAction('districtInfo')) {
            $operateList['allow_operate_edit'] = 1;
        }
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('districtShow')) {
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