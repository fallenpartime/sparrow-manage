<?php
/**
 * 社会实践记录
 * Date: 2018/10/8
 * Time: 22:43
 */
namespace App\Http\Admin\Actions\Article\Practice;

use Common\Models\Article\Article;
use App\Http\Admin\Actions\Article\BaseInfoAction;
use Frameworks\Tool\Http\Config\HttpConfig;

class InfoAction extends BaseInfoAction
{
    protected $_type = 3;
    protected $_typeName = '社会实践记录';

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
        return $this->showInfo();
    }

    protected function showInfo()
    {
        $result = [
            'record'            =>  $this->_article,
            'articleType'       =>  1,
            'menu'              =>  ['articleCenter', 'practiceManage', 'articlePracticeInfo'],
            'actionUrl'         => route('articlePracticeInfo'),
        ];
        return $this->createView('admin.article.practice.info', $result);
    }
}
