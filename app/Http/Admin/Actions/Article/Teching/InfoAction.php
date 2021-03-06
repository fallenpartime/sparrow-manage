<?php
/**
 * 教研活动
 * Date: 2018/10/8
 * Time: 22:43
 */
namespace App\Http\Admin\Actions\Article\Teching;

use Common\Models\Article\Article;
use App\Http\Admin\Actions\Article\BaseInfoAction;
use Frameworks\Tool\Http\Config\HttpConfig;

class InfoAction extends BaseInfoAction
{
    protected $_type = 4;
    protected $_typeName = '教研活动';

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
            'menu'              =>  ['articleCenter', 'techingManage', 'articleTechingInfo'],
            'actionUrl'         => route('articleTechingInfo'),
        ];
        return $this->createView('admin.article.teching.info', $result);
    }
}
