<?php
/**
 * 文章缓存刷新
 * Date: 2018/10/23
 * Time: 21:36
 */
namespace App\Http\Admin\Actions\Article\Operate;

use Admin\Actions\BaseAction;
use Admin\Models\Article\Article;
use Admin\Services\Article\ArticleService;
use Admin\Services\Log\LogService;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class FreshAction extends BaseAction
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
        $data = [
            'id'        =>  $this->_article->id,
            'type'      =>  $this->_article->type,
            'title'     =>  $this->_article->title,
            'author'    =>  $this->_article->author,
            'description'   =>  $this->_article->description,
            'content'   =>  $this->_article->content,
            'is_show'       =>  $this->_article->is_show,
            'list_pic'      =>  $this->_article->list_pic,
            'read_count'    =>  $this->_article->read_count,
            'like_count'    =>  $this->_article->like_count,
            'published_at'  =>  $this->_article->published_at,
        ];
        LogService::operateLog($this->request, 5, $this->_article->id, "文章缓存刷新", $this->getAuthService()->getAdminInfo());
        $articleService = new ArticleService($this->_article->id);
        $articleService->setCacheRecord($data);
        $this->successJson('');
    }
}
