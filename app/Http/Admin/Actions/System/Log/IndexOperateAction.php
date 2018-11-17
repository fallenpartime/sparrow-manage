<?php
/**
 * 业务日志
 * Date: 2018/10/22
 * Time: 4:26
 */
namespace App\Http\Admin\Actions\System\Log;

use Admin\Actions\BaseAction;
use Admin\Config\AdminConfig;
use Admin\Models\System\OperateLog;
use Admin\Services\Common\CommonService;
use Admin\Services\Master\MasterService;
use Admin\Services\Sql\System\Log\OperateLogSqlProcessor;

class IndexOperateAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route('operateLogs');
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new OperateLogSqlProcessor())->getListSql(new OperateLog(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with('user')->select(['id', 'user_id', 'operate_type', 'object_id', 'memo', 'ip', 'created_at'])->get();
        }
        list($url, $pageList) = CommonService::pagination($total, $pageSize, $page, $url);
        $typeList = AdminConfig::getOperateList();
        $owners = (new MasterService())->masterList();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'typeList'      => $typeList,
            'owners'        => $owners,
            'menu'          => ['manageCenter', 'logManage', 'operateLogs'],
            'redirectUrl'   => route('operateLogs'),
        ];
        return $this->createView('admin.system.log.operatelog', $result);
    }
}
