<?php
/**
 * 教育新闻详情
 * Date: 2018/10/8
 * Time: 22:43
 */
namespace App\Http\Admin\Actions\Article\News;

use Common\Models\Article\Article;
use App\Http\Admin\Actions\Article\BaseInfoAction;
use Frameworks\Tool\Http\Config\HttpConfig;

class InfoAction extends BaseInfoAction
{
    protected $_type = 1;
    protected $_typeName = '教育时讯';

    public function run()
    {
        $httpTool = $this->getHttpTool();
        $id = $httpTool->getBothSafeParam('id', HttpConfig::PARAM_NUMBER_TYPE);
        if (!empty($id)) {
            $this->_article = Article::find($id);
        }
        if ($httpTool->isAjax()) {
            $this->process();
        }
        $this->errorJson(500, '请求类型不匹配');
    }

    protected function showInfo()
    {
        $result = [
            'record'            =>  $this->_article,
            'articleType'       =>  1,
            'menu'              =>  ['articleCenter', 'newsManage', 'articleNewsInfo'],
            'actionUrl'         => route('articleNewsInfo'),
        ];
        return $this->createView('admin.article.news.info', $result);
    }
}
