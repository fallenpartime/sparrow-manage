<?php
/**
 * 用户意见作废
 * Date: 2018/10/23
 * Time: 9:46
 */
namespace App\Http\Admin\Actions\Interact\Admonition;

use Admin\Actions\BaseAction;
use Admin\Models\User\UserAdmonition;
use Admin\Services\Log\LogService;
use Admin\Services\User\Processor\UserAdmonitionProcessor;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class RemoveAction extends BaseAction
{
    use ApiActionTrait;

    protected $_admonition = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_admonition = UserAdmonition::find($id);
        }
        if (empty($this->_admonition)) {
            $this->errorJson(500, '用户意见不存在');
        }
        $this->process();
    }

    protected function process()
    {
        LogService::operateLog($this->request, 50, $this->_admonition->id, "用户意见作废", $this->getAuthService()->getAdminInfo());
        $res = (new UserAdmonitionProcessor())->destroy($this->_admonition->id);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}
