<?php
/**
 *
 * Date: 2018/10/2
 * Time: 23:02
 */
namespace Front\Action;

use Frameworks\Tool\Http\Config\HttpConfig;
use Frameworks\Tool\Http\HttpTool;
use Common\Config\PaginationConfig;
use Illuminate\Http\Request;

class BaseAction
{
    protected $request = null;
    protected $httpTool = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function getHttpTool()
    {
        if (empty($this->httpTool)) {
            $this->httpTool = new HttpTool($this->request);
        }
        return $this->httpTool;
    }

    protected function getPageParams()
    {
        $page = $this->getHttpTool()->getBothSafeParam('page', HttpConfig::PARAM_NUMBER_TYPE);
        $page = $page > 0? $page: 1;
        return [$page, PaginationConfig::PAGE_SIZE];
    }

    protected function pageModel($model, $page, $pageSize)
    {
        $offset = ($page - 1) * $pageSize;
        $model = $model->offset($offset)->limit($pageSize);
        return $model;
    }

    protected function redirect($message)
    {
        exit("<script>alert('{$message}');location.href=document.referrer;</script>");
    }

    protected function isPost()
    {
        if ($this->request->isMethod('post')) {
            return true;
        }
        return false;
    }

    public function run()
    {}
}
