<?php
/**
 * hash工具
 * Date: 2018/10/30
 * Time: 9:29
 */
namespace Frameworks\Tool\Random;

use Vinkla\Hashids\Facades\Hashids;

class HashTool
{

    /**
     * 生成hashids
     * @param $params
     * @return mixed
     */
    public function encode(...$params)
    {
        if (!is_array($params)) {
            return Hashids::encode($params);
        }
        return call_user_func_array([Hashids::class, 'encode'], $params);
    }

    /**
     * hashid解码
     * @param $code
     * @return null
     */
    public function decode($code)
    {
        if (empty($code)) {
            return null;
        }
        $params = Hashids::decode($code);
        if (is_array($params)) {
            return $params;
        }
        return [];
    }
}
