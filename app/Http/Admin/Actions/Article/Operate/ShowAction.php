<?php
/**
 * 文章显示状态修改
 * Date: 2018/10/8
 * Time: 1:58
 */
namespace App\Http\Admin\Actions\Article\Operate;

use Admin\Actions\BaseAction;
use Admin\Models\Article\Article;
use Admin\Services\Article\ArticleService;
use Admin\Services\Article\Processor\ArticleProcessor;
use Admin\Services\Log\LogService;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class ShowAction extends BaseAction
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
        $showValue = $this->_article->is_show;
        $showValue = ($showValue + 1) % 2;
        if ($showValue == 1 && empty($this->_article->published_at)) {
            $this->errorJson(500, '发布时间未设置，不可设置显示');
        }
        if ($showValue == 1) {
            if (empty($this->_article->published_at)) {
                $this->errorJson(500, '文章发布时间不能为空');
            }
            if (empty($this->_article->author)) {
                $this->errorJson(500, '文章作者不能为空');
            }
        }
        LogService::operateLog($this->request, 4, $this->_article->id, "文章显示状态修改：{$this->_article->is_show}=>{$showValue}", $this->getAuthService()->getAdminInfo());
        $res = (new ArticleProcessor())->update($this->_article->id, ['is_show'=>$showValue]);
        if ($res) {
            // 文章缓存显示状态修改
            $articleService = new ArticleService($this->_article->id);
            $articleService->setCacheRecord(['is_show'=>$showValue]);
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }
}
