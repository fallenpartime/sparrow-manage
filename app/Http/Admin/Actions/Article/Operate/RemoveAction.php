<?php
/**
 * 文章作废
 * Date: 2018/10/20
 * Time: 1:14
 */
namespace App\Http\Admin\Actions\Article\Operate;

use Admin\Actions\BaseAction;
use Admin\Models\Article\Article;
use Admin\Services\Article\ArticleService;
use Admin\Services\Article\Processor\ArticleProcessor;
use Admin\Services\Log\LogService;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class RemoveAction extends BaseAction
{
    use ApiActionTrait;

    protected $_article = null;

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_article = Article::find($id);
        }
        if (empty($this->_article)) {
            $this->errorJson(500, '文章不存在');
        }
        $this->process();
    }

    protected function process()
    {
        LogService::operateLog($this->request, 3, $this->_article->id, '作废文章', $this->getAuthService()->getAdminInfo());
        $res = (new ArticleProcessor())->destroy($this->_article->id);
        if ($res) {
            // 作废文章缓存
            $articleService = new ArticleService($this->_article->id);
            $articleService->removeCacheRecord();
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}
