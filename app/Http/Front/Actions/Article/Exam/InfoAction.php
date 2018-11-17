<?php
/**
 * 教育快讯列表
 * Date: 2018/10/30
 * Time: 0:05
 */
namespace App\Http\Front\Actions\Article\Exam;

use Front\Action\BaseAction;
use Front\Traits\ArticleActionTrait;
use Front\Traits\ErrorActionTrait;

class InfoAction extends BaseAction
{
    use ArticleActionTrait, ErrorActionTrait;

    protected $type = 2;

    public function run()
    {
        if (!$this->initRecordByCode()) {
            return $this->errorArticleRedirect('文章不见啦');
        }
        $this->getService()->readCounter();
        $result = [
            'record'        =>  $this->record,
            'like_url'      =>  $this->likeUrl,
        ];
        return view('front.article.exam.info', $result);
    }
}
