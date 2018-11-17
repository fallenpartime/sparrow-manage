<?php
/**
 * 网络投票活动列表
 * Date: 2018/10/20
 * Time: 22:14
 */
namespace App\Http\Admin\Actions\Activity\Poll;

use Admin\Actions\BaseAction;
use Admin\Models\Activity\Activity;
use Admin\Services\Activity\ActivityService;
use Admin\Services\Common\CommonService;
use Admin\Services\Sql\Activity\Poll\IndexSqlProcessor;

class IndexAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route('news');
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new IndexSqlProcessor())->getListSql(new Activity(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with('picture')->select(['id', 'type', 'title', 'author', 'is_show', 'is_open', 'read_count', 'join_count', 'list_pic', 'created_at', 'published_at', 'opened_at', 'overed_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonService::pagination($total, $pageSize, $page, $url);
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'          => ['activityCenter', 'pollManage', 'polls'],
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route('polls'),
        ];
        return $this->createView('admin.activity.poll.index', $result);
    }

    protected function allowOperate()
    {
        $operateList = [
            'change_show' => 0,
            'change_open' => 0,
            'change_remove' => 0,
            'create_question' => 0,
            'change_fresh' => 0,
        ];
        $operateUrl = [
            'change_url'    => '',
            'open_url'      => '',
            'remove_url'      => '',
            'question_url'    => '',
            'fresh_url'    => '',
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('activityShow')) {
            $operateList['change_show'] = 1;
            $operateUrl['change_url'] = route('activityShow');
        }
        if ($authService->isMaster || $authService->validateAction('activityOpen')) {
            $operateList['change_open'] = 1;
            $operateUrl['open_url'] = route('activityOpen');
        }
        if ($authService->isMaster || $authService->validateAction('activityRemove')) {
            $operateList['change_remove'] = 1;
            $operateUrl['remove_url'] = route('activityRemove');
        }
        if ($authService->isMaster || $authService->validateAction('activityPollQuestionInfo')) {
            $operateList['create_question'] = 1;
            $operateUrl['question_url'] = route('activityPollQuestionInfo', ['work_no'=>1]);
        }
        if ($authService->isMaster || $authService->validateAction('activityFresh')) {
            $operateList['change_fresh'] = 1;
            $operateUrl['fresh_url'] = route('activityFresh');
        }
        return [$operateList, $operateUrl];
    }

    protected function listAllowOperate($list, $key)
    {
        $operateList = [
            'allow_operate_edit' => 0,
            'allow_operate_show' => 0,
            'allow_operate_open' => 0,
            'allow_operate_close' => 0,
            'allow_operate_remove' => 0,
            'allow_operate_question' => 0,
            'allow_operate_fresh' => 0
        ];
        $author = $list[$key]->author;
        $isShow = $list[$key]->is_show;
        $isOpen = $list[$key]->is_open;
        $openAt = $list[$key]->opened_at;
        $overedAt = $list[$key]->overed_at;
        $publishedAt = $list[$key]->published_at;
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('activityPollInfo')) {
            $operateList['allow_operate_edit'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction('activityShow')) {
            if ($isShow == 0) {
                if (!empty($publishedAt) && !empty($author)) {
                    $operateList['allow_operate_show'] = 1;
                }
            } else {
                $operateList['allow_operate_show'] = 1;
            }
        }
        if ($authService->isMaster || $authService->validateAction('activityOpen')) {
            if (empty($isOpen)) {
                if (!empty($publishedAt) && !empty($author) && empty($openAt)) {
                    $operateList['allow_operate_open'] = 1;
                }
            } else {
                if (empty($overedAt)) {
                    $operateList['allow_operate_close'] = 1;
                }
            }
        }
        if ($authService->isMaster || $authService->validateAction('activityRemove')) {
            $operateList['allow_operate_remove'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction('activityPollQuestionInfo')) {
            $operateList['allow_operate_question'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction('activityFresh')) {
            $operateList['allow_operate_fresh'] = 1;
        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }

    protected function processList($list)
    {
        $service = new ActivityService();
        foreach ($list as $key => $item) {
            $list[$key]->edit_url = route('activityPollInfo', ['work_no'=>1, 'id'=>$item->id]);
            $list[$key]->show_url = $service->_init($item->id)->getPreviewShowUrl($item->type);
            $list = $this->getActivityOpenStatus($list, $key);
            $list = $this->listAllowOperate($list, $key);
        }
        return $list;
    }

    protected function getActivityOpenStatus($list, $key)
    {
        $isOpen = $list[$key]->is_open;
        $overedAt = $list[$key]->overed_at;
        if ($isOpen == 0) {
            $list[$key]->open_status = '未开启';
        } else {
            if(!empty($overedAt)) {
                $list[$key]->open_status = '已结束';
            } else {
                $list[$key]->open_status = '进行中';
            }
        }
        return $list;
    }
}
