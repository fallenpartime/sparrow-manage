<?php
/**
 * 网络投票活动汇总
 * Date: 2018/10/22
 * Time: 3:16
 */
namespace App\Http\Admin\Actions\Activity\Poll\Question;

use Admin\Actions\BaseAction;
use Admin\Models\Activity\ActivityQuestion;
use Admin\Services\Activity\Integration\QuestionDataIntegration;
use Admin\Services\Common\CommonService;
use Admin\Services\Sql\Activity\Poll\QuestionDataSqlProcessor;

class IndexDataAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route('activityPollVoteData');
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new QuestionDataSqlProcessor())->getListSql(new ActivityQuestion(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with('activity')->select(['id', 'activity_id', 'type', 'title', 'source', 'is_show', 'is_checkbox', 'created_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonService::pagination($total, $pageSize, $page, $url);
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'          => ['activityCenter', 'pollManage', 'activityPollVoteData'],
        ];
        return $this->createView('admin.activity.poll.question.data', $result);
    }

    protected function processList($list)
    {
        if (!empty($list)) {
            $dataIntegration = new QuestionDataIntegration();
            foreach ($list as $key => $item) {
                list($status, $message, $answerData, $otherData) = $dataIntegration->_init($item->id)->process();
                $list[$key]->other_option = ['answer' => $answerData, 'other' => $otherData];
            }
        }
        return $list;
    }
}
