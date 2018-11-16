<?php
/**
 * request扩展
 * Date: 2018/11/16
 * Time: 23:39
 */
namespace Frameworks\Tool\Http\Traits;

trait RequestTrait
{
    protected $request = null;

    /**
     * 是否https请求
     * @return mixed
     */
    public function isSecure()
    {
        return $this->request->isSecure();
    }

    /**
     * 是否ajax请求
     * @return mixed
     */
    public function isAjax()
    {
        return $this->request->ajax();
    }

    /**
     * 是否post请求
     * @return mixed
     */
    public function isPost()
    {
        return $this->isMethod('POST');
    }
}
