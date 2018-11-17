<?php
/**
 * 用户意见列表
 * Date: 2018/10/22
 * Time: 3:45
 */
namespace App\Http\Admin\Actions\Interact\Admonition;

use Admin\Actions\BaseAction;
use Admin\Models\User\UserAdmonition;
use Admin\Services\Common\CommonService;
use Admin\Services\Sql\User\Admonition\IndexSqlProcessor;

class IndexAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route('admonitions');
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new IndexSqlProcessor())->getListSql(new UserAdmonition(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with('user')->select(['id', 'user_id', 'name', 'phone', 'content', 'reply_content', 'is_show', 'created_at', 'reply_at', 'reply_owner'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonService::pagination($total, $pageSize, $page, $url);
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'          => ['interactCenter', 'admonitionManage', 'admonitions'],
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route('admonitions'),
        ];
        return $this->createView('admin.interact.admonition.index', $result);
    }

    protected function allowOperate()
    {
        $operateList = [
            'change_show'   => 0,
            'change_remove' => 0,
            'change_reply'  => 0
        ];
        $operateUrl = [
            'change_url'    => '',
            'remove_url'    => '',
            'reply_url'     => ''
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('admonitionShow')) {
            $operateList['change_show'] = 1;
            $operateUrl['change_url'] = route('admonitionShow');
        }
        if ($authService->isMaster || $authService->validateAction('admonitionRemove')) {
            $operateList['change_remove'] = 1;
            $operateUrl['remove_url'] = route('admonitionRemove');
        }
        if ($authService->isMaster || $authService->validateAction('admonitionReply')) {
            $operateList['change_reply'] = 1;
            $operateUrl['reply_url'] = route('admonitionReply');
        }
        return [$operateList, $operateUrl];
    }

    protected function listAllowOperate($list, $key)
    {
        $operateList = [
            'allow_operate_show' => 0,
            'allow_operate_remove' => 0,
            'allow_operate_reply'  => 0,
            'allow_operate_modify_reply'  => 0
        ];
        $replyContent = $list[$key]->reply_content;
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('admonitionShow')) {
            $operateList['allow_operate_show'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction('admonitionRemove')) {
            $operateList['allow_operate_remove'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction('admonitionReply')) {
            if (empty($replyContent)) {
                $operateList['allow_operate_reply'] = 1;
            } else {
                $operateList['allow_operate_modify_reply'] = 1;
            }
        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }

    protected function processList($list)
    {
        foreach ($list as $key => $item) {
            $list = $this->listAllowOperate($list, $key);
        }
        return $list;
    }
}
