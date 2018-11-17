<?php
/**
 * 社会实践记录
 * Date: 2018/10/8
 * Time: 1:58
 */
namespace App\Http\Admin\Actions\Article\Practice;

use Admin\Actions\BaseAction;
use Admin\Models\Article\Article;
use Admin\Services\Article\ArticleService;
use Admin\Services\Common\CommonService;
use Admin\Services\Sql\Article\PracticeSqlProcessor;

class IndexAction extends BaseAction
{
    public function run()
    {
        $httpTool = $this->getHttpTool();
        $url = route('practices');
        list($page, $pageSize) = $this->getPageParams();
        $requestParams = $httpTool->getParams();
        list($model, $urlParams, $url) = (new PracticeSqlProcessor())->getListSql(new Article(), $requestParams, $url);
        $list = [];
        $total = $model->count();
        if ($total > 0) {
            $list = $this->pageModel($model, $page, $pageSize)->with('picture')->select(['id', 'type', 'title', 'author', 'is_show', 'read_count', 'like_count', 'list_pic', 'created_at', 'published_at'])->get();
            $list = $this->processList($list);
        }
        list($url, $pageList) = CommonService::pagination($total, $pageSize, $page, $url);
        list($operateList, $operateUrl) = $this->allowOperate();
        $result = [
            'list'          => $list,
            'pageList'      => $pageList,
            'urlParams'     => $urlParams,
            'menu'          => ['articleCenter', 'practiceManage', 'practices'],
            'operateList'   => $operateList,
            'operateUrl'    => $operateUrl,
            'redirectUrl'   => route('practices'),
        ];
        return $this->createView('admin.article.practice.index', $result);
    }

    protected function allowOperate()
    {
        $operateList = [
            'change_show'   => 0,
            'change_remove' => 0,
            'change_fresh'  => 0
        ];
        $operateUrl = [
            'change_url' => '',
            'remove_url' => '',
            'fresh_url'  => ''
        ];
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('articleShow')) {
            $operateList['change_show'] = 1;
            $operateUrl['change_url'] = route('articleShow');
        }
        if ($authService->isMaster || $authService->validateAction('articleRemove')) {
            $operateList['change_remove'] = 1;
            $operateUrl['remove_url'] = route('articleRemove');
        }
        if ($authService->isMaster || $authService->validateAction('articleFresh')) {
            $operateList['change_fresh'] = 1;
            $operateUrl['fresh_url'] = route('articleFresh');
        }
        return [$operateList, $operateUrl];
    }

    protected function listAllowOperate($list, $key)
    {
        $operateList = [
            'allow_operate_edit' => 0,
            'allow_operate_change' => 0,
            'allow_operate_remove' => 0,
            'allow_operate_fresh'  => 0
        ];
        $author = $list[$key]->author;
        $isShow = $list[$key]->is_show;
        $publishedAt = $list[$key]->published_at;
        $authService = $this->getAuthService();
        if ($authService->isMaster || $authService->validateAction('articleExamInfo')) {
            $operateList['allow_operate_edit'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction('articleShow')) {
            if ($isShow == 0) {
                if (!empty($author) && !empty($publishedAt)) {
                    $operateList['allow_operate_change'] = 1;
                }
            } else {
                $operateList['allow_operate_change'] = 1;
            }
        }
        if ($authService->isMaster || $authService->validateAction('articleRemove')) {
            $operateList['allow_operate_remove'] = 1;
        }
        if ($authService->isMaster || $authService->validateAction('articleFresh')) {
            $operateList['allow_operate_fresh'] = 1;
        }
        $list[$key]->operate_list = $operateList;
        return $list;
    }

    protected function processList($list)
    {
        $service = new ArticleService();
        foreach ($list as $key => $item) {
            $list[$key]->edit_url = route('articlePracticeInfo', ['work_no'=>1, 'id'=>$item->id]);
            $list[$key]->show_url = $service->_init($item->id)->getPreviewShowUrl($item->type);
            $list = $this->listAllowOperate($list, $key);
        }
        return $list;
    }
}
