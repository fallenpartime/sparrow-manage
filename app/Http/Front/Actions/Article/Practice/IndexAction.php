<?php
/**
 * 社会实践记录列表
 * Date: 2018/10/30
 * Time: 0:01
 */
namespace App\Http\Front\Actions\Article\Practice;

use Admin\Traits\ApiActionTrait;
use Front\Actions\BaseAction;
use Front\Traits\Lists\ArticleActionTrait;

class IndexAction extends BaseAction
{
    use ArticleActionTrait, ApiActionTrait;

    protected $type = 3;

    public function run()
    {
        if ($this->isPost()) {
            $this->processList();
        }
        return $this->show();
    }

    protected function show()
    {
        return view('front.article.practice.index', ['pull_url'=>route('front.practices')]);
    }
}
