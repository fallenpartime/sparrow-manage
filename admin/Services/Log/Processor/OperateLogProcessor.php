<?php
/**
 * 业务日志
 * Date: 2018/10/23
 * Time: 15:17
 */
namespace Admin\Services\Log\Processor;


use Common\Models\System\OperateLog;
use Frameworks\Services\Basic\Processor\BaseProcessor;

class OperateLogProcessor extends BaseProcessor
{
    protected $tableName = 'operate_logs';
    protected $tableClass = OperateLog::class;
}
