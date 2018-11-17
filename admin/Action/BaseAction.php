<?php
/**
 *
 * Date: 2018/10/2
 * Time: 23:02
 */
namespace Admin\Action;

use Admin\Services\Auth\AuthService;
use Frameworks\Tool\Http\Config\HttpConfig;
use Frameworks\Tool\Http\HttpTool;
use Illuminate\Http\Request;

class BaseAction
{
    protected $request = null;
    protected $httpTool = null;
    protected $authService = null;

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

    protected function getAuthService()
    {
        if (empty($this->authService)) {
            $this->authService = new AuthService($this->request);
        }
        return $this->authService;
    }

    protected function initAdminResult($result)
    {
        $service = $this->getAuthService();
        $result['admin_info'] = $service->getAdminInfo();
        $result['ts_list'] = $service->getActionList();
        return $result;
    }

    protected function createView($view, $result)
    {
        $result = $this->initAdminResult($result);
        return view($view, $result);
    }

    protected function getPageParams()
    {
        $page = $this->getHttpTool()->getBothSafeParam('page', HttpConfig::PARAM_NUMBER_TYPE);
        $page = $page > 0? $page: 1;
        return [$page, 20];
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

    public function run()
    {}
}