<?php
/**
 * 投票问题列表
 * Date: 2018/10/20
 * Time: 22:34
 */
namespace App\Http\Admin\Actions\Activity\Poll\Question;

use Admin\Actions\BaseAction;
use Admin\Models\Activity\ActivityQuestion;
use Admin\Services\Common\CommonService;
use Admin\Services\Sql\Activity\Poll\QuestionSqlProcessor;

class IndexAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route('activityPollQuestions');
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new QuestionSqlProcessor())->getListSql(new ActivityQuestion(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with('activity')->select(['id', 'activity_id', 'type', 'title', 'source', 'is_show', 'is_checkbox', 'created_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonService::pagination($total, $pageSize, $page, $url);
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'          => ['activityCenter', 'pollManage', 'activityPollQuestions'],
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route('activityPollQuestions'),
        ];
        return $this->createView('admin.activity.poll.question.index', $result);
    }

    protected function processList($list)
    {
        if (!empty($list)) {
            foreach ($list as $key => $item) {
                $list = $this->listAllowOperate($list, $key);
            }
        }
        return $list;
    }

    protected function allowOperate()
    {
        $operateList = [
            'change_show' => 0,
            'change_remove' => 0
        ];
        $operateUrl = [
            'change_url'    => '',
            'remove_url'      => ''
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('activityQuestionShow')) {
            $operateList['change_show'] = 1;
            $operateUrl['change_url'] = route('activityQuestionShow');
        }
        if ($authService->isMaster || $authService->validateAction('activityQuestionRemove')) {
            $operateList['change_remove'] = 1;
            $operateUrl['remove_url'] = route('activityQuestionRemove');
        }
        return [$operateList, $operateUrl];
    }

    protected function listAllowOperate($list, $key)
    {
        $operateList = [
            'allow_operate_edit' => 0,
            'allow_operate_show' => 0,
            'allow_operate_remove' => 0
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('activityPollQuestionInfo')) {
            $operateList['allow_operate_edit'] = 1;
            $list[$key]->edit_url = route('activityPollQuestionInfo', ['id'=>$list[$key]->id, 'work_no'=>1]);
        }
        if ($authService->isMaster || $authService->validateAction('activityQuestionShow')) {
            $operateList['allow_operate_show'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction('activityQuestionRemove')) {
            $operateList['allow_operate_remove'] = 1;
        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }
}