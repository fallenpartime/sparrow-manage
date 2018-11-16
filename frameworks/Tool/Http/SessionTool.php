<?php
/**
 * session工具
 * Date: 2018/10/7
 * Time: 17:53
 */
namespace Frameworks\Tool\Http;

use Illuminate\Http\Request;

class SessionTool
{
    protected $request = null;
    protected $session = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getSession()
    {
        if (empty($this->session)) {
            $this->session = $this->request->getSession();
        }
        return $this->session;
    }

    public function set($key, $value)
    {
        $this->getSession()->set($key, $value);
    }

    public function remove($key)
    {
        $this->getSession()->remove($key);
    }

    public function get($key)
    {
        return $this->getSession()->get($key);
    }
}
