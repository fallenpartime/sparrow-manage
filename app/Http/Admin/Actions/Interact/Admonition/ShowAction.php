<?php
/**
 * 用户意见显示状态修改
 * Date: 2018/10/23
 * Time: 9:50
 */
namespace App\Http\Admin\Actions\Interact\Admonition;

use Admin\Actions\BaseAction;
use Admin\Models\User\UserAdmonition;
use Admin\Services\Log\LogService;
use Admin\Services\User\Processor\UserAdmonitionProcessor;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class ShowAction extends BaseAction
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
        $showValue = $this->_admonition->is_show;
        $showValue = ($showValue + 1) % 2;
        LogService::operateLog($this->request, 52, $this->_admonition->id, "用户意见显示状态修改：{$this->_admonition->is_show}=>{$showValue}", $this->getAuthService()->getAdminInfo());
        $res = (new UserAdmonitionProcessor())->update($this->_admonition->id, ['is_show'=>$showValue]);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}
