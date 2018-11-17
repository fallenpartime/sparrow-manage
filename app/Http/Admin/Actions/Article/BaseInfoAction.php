<?php
/**
 * 基础文章操作
 * Date: 2018/10/29
 * Time: 11:25
 */
namespace App\Http\Admin\Actions\Article;

use Admin\Actions\BaseAction;
use Admin\Services\Article\ArticleService;
use Admin\Services\Article\Processor\ArticlePictureProcessor;
use Admin\Services\Article\Processor\ArticleProcessor;
use Admin\Services\Log\LogService;
use Admin\Traits\ApiActionTrait;
use Frameworks\Tool\Http\HttpConfig;

class BaseInfoAction extends BaseAction
{
    use ApiActionTrait;

    protected $_article = null;
    protected $_type = 0;
    protected $_typeName = '';
    protected $pictureProcessor = null;

    protected function getPictureProcessor()
    {
        if (empty($this->pictureProcessor)) {
            $this->pictureProcessor = new ArticlePictureProcessor();
        }
        return $this->pictureProcessor;
    }

    protected function process()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        $title = $httpTool->getBothSafeParam('title');
        $author = $httpTool->getBothSafeParam('author');
        $description = $httpTool->getBothSafeParam('description');
        $content = request('content');
        $publishedAt = $httpTool->getBothSafeParam('pubdate');
        $picPreview = $this->request->get('list_pic_preview');
        $title = trim($title);
        $author = trim($author);
        $description = trim($description);
        $publishedAt = trim($publishedAt);
        if(empty($title)){
            $this->errorJson(500, '标题不能为空');
        }
        if(empty($description)){
            $this->errorJson(500, '描述不能为空');
        }
        if(empty($content)){
            $this->errorJson(500, '内容不能为空');
        }
        if (!empty($id) && empty($this->_article)) {
            $this->errorJson(500, '文章不存在');
        }
        if (!empty($this->_article)) {
            if ($this->_article->is_show) {
                if (empty($author)) {
                    $this->errorJson(500, '文章作者不能为空');
                }
                if (empty($publishedAt)) {
                    $this->errorJson(500, '文章发布时间不能为空');
                }
            }
        }
        $data = [
            'type'      =>  $this->_type,
            'title'     =>  $title,
            'author'    =>  $author,
            'description'   =>  $description,
            'content'   =>  $content,
            'published_at'  =>  !empty($publishedAt)? $publishedAt: null,
            'list_pic'      =>  !empty($picPreview)?  $picPreview[0]: null,
        ];
        $res = empty($this->_article)? $this->save($data): $this->update($data);
        if ($res) {
            $this->successJson();
        }
        $this->errorJson(500, '提交失败');
    }

    protected function clearImage($articleId)
    {
        if ($articleId > 0) {
            $this->getPictureProcessor()->remove(['article_id'=>$articleId, 'type'=>1]);
        }
    }

    protected function processImage($imageUrl, $articleId, $create = 0)
    {
        $imageUrl = trim($imageUrl);
        if ($articleId <= 0) {
            return false;
        }
        if (!empty($imageUrl)) {
            $data = [
                'article_id'    =>  $articleId,
                'type'          =>  1,
                'pic'           =>  $imageUrl,
            ];
        }
        if ($create == 1) {
            $this->clearImage($articleId);
            if (!empty($data)) {
                list($status, $picture) = $this->getPictureProcessor()->insert($data);
                return $status;
            }
        } else {
            if (empty($imageUrl)) {
                $this->clearImage($articleId);
            } else if($imageUrl != $this->_article->list_pic) {
                $this->clearImage($articleId);
                if (!empty($data)) {
                    list($status, $picture) = $this->getPictureProcessor()->insert($data);
                    return $status;
                }
            }
        }
        return false;
    }

    protected function processCache($id, $data)
    {
        $service = new ArticleService($id);
        $service->setCacheRecord($data);
    }

    protected function save($data)
    {
        $processor = new ArticleProcessor();
        list($status, $article) = $processor->insert($data);
        if (empty($status)) {
            $this->errorJson(500, '文章创建失败');
        }
        LogService::operateLog($this->request, 1, $article->id, '添加文章', $this->getAuthService()->getAdminInfo());
        $data['id'] = $article->id;
        $data['is_show'] = 0;
        $data['read_count'] = 0;
        $data['like_count'] = 0;
        $this->processCache($article->id, $data);
        $this->processImage($data['list_pic'], $article->id, 1);
        $this->successJson();
    }

    protected function update($data)
    {
        if ($this->_article->type != $this->_type) {
            $this->errorJson(500, "文章类别非{$this->_typeName}类型");
        }
        LogService::operateLog($this->request, 2, $this->_article->id, '编辑文章', $this->getAuthService()->getAdminInfo());
        $processor = new ArticleProcessor();
        list($status, $id) = $processor->update($this->_article->id, $data);
        if (empty($status)) {
            $this->errorJson(500, '文章修改失败');
        }
        $this->processCache($this->_article->id, $data);
        $this->processImage($data['list_pic'], $id);
        $this->successJson();
    }
}
