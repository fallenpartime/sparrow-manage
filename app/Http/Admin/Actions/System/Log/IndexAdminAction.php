<?php
/**
 * 系统日志
 * Date: 2018/10/22
 * Time: 4:26
 */
namespace App\Http\Admin\Actions\System\Log;

use Admin\Actions\BaseAction;
use Admin\Config\AdminConfig;
use Admin\Models\System\AdminLog;
use Admin\Services\Common\CommonService;
use Admin\Services\Master\MasterService;
use Admin\Services\Sql\System\Log\AdminLogSqlProcessor;

class IndexAdminAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route('adminLogs');
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new AdminLogSqlProcessor())->getListSql(new AdminLog(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with('user')->select(['id', 'user_id', 'operate_type', 'object_id', 'memo', 'ip', 'created_at'])->get();
        }
        list($url, $pageList) = CommonService::pagination($total, $pageSize, $page, $url);
        $typeList = AdminConfig::getAdminOperateList();
        $owners = (new MasterService())->masterList();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'typeList'      => $typeList,
            'owners'        => $owners,
            'menu'          => ['manageCenter', 'logManage', 'adminLogs'],
            'redirectUrl'   => route('adminLogs'),
        ];
        return $this->createView('admin.system.log.adminlog', $result);
    }
}
