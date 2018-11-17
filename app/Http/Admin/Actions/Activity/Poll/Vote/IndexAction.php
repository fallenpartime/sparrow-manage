<?php
/**
 * 网络投票明细
 * Date: 2018/10/22
 * Time: 3:15
 */
namespace App\Http\Admin\Actions\Activity\Poll\Vote;

use Admin\Action\BaseAction;
use Common\Models\Activity\ActivityVote;
use Admin\Services\Common\CommonService;
use Admin\Services\Sql\Activity\Poll\VoteSqlProcessor;

class IndexAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route('activityPollVotes');
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new VoteSqlProcessor())->getListSql(new ActivityVote(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with(['user', 'activity', 'question', 'answer'])->select(['id', 'activity_id', 'user_id', 'type', 'question_id', 'answer_id', 'other', 'created_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonService::pagination($total, $pageSize, $page, $url);
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'          => ['activityCenter', 'pollManage', 'activityPollVotes'],
        ];
        return $this->createView('admin.activity.poll.vote.index', $result);
    }

    protected function processList($list)
    {
        if (!$list->isEmpty()) {
            foreach ($list as $key => $item) {
            }
        }
        return $list;
    }
}
