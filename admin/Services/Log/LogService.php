<?php
/**
 * 日志服务
 * Date: 2018/10/23
 * Time: 15:18
 */
namespace Admin\Services\Log;

use Admin\Services\Auth\AuthService;
use Admin\Services\Log\Processor\AdminLogProcessor;
use Admin\Services\Log\Processor\OperateLogProcessor;
use Frameworks\Tool\Http\HttpTool;
use Illuminate\Http\Request;

class LogService
{
    /**
     * 业务日志
     * @param $request
     * @param $operateType
     * @param $objectId
     * @param $memo
     * @param null $adminInfo
     */
    public static function operateLog(Request $request, $operateType, $objectId, $memo, $adminInfo = null)
    {
        if (empty($adminInfo)) {
            $adminInfo = (new AuthService($request))->getAdminInfo();
        }
        $logData = [
            'operate_type'  => $operateType,
            'object_id'  => $objectId,
            'memo'      => $memo,
            'user_id'    => $adminInfo['userid'],
            'ip'        => $request->getClientIp(),
        ];
        (new OperateLogProcessor())->insert($logData);
    }

    /**
     * 系统日志
     * @param $request
     * @param $operateType
     * @param $objectId
     * @param $memo
     * @param null $adminInfo
     */
    public static function adminLog(Request $request, $operateType, $objectId, $memo, $adminInfo = null)
    {
        if (empty($adminInfo)) {
            $adminInfo = (new AuthService($request))->getAdminInfo();
        }
        $logData = [
            'operate_type'  => $operateType,
            'object_id'  => $objectId,
            'memo'      => $memo,
            'user_id'    => $adminInfo['userid'],
            'ip'        => $request->getClientIp(),
        ];
        (new AdminLogProcessor())->insert($logData);
    }
}
