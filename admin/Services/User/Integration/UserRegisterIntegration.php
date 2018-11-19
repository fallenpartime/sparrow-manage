<?php
/**
 * 用户注册
 * Date: 2018/11/18
 * Time: 16:56
 */
namespace Admin\Services\User\Integration;

use Frameworks\Services\Basic\Processor\BaseWorkProcessor;

class UserRegisterIntegration extends BaseWorkProcessor
{
    protected $userData = [];

    public function __construct($userData)
    {
        $this->_init($userData);
    }

    public function _init($userData)
    {
        $this->userData = $userData;
        return $this;
    }

    public function process()
    {
        $userData = $this->userData;
        if (empty($userData)) {
            return $this->parseResult('', []);
        }
//        if () {
//
//        }
    }

    protected function insertUser()
    {
        $data = '{
    "subscribe": 1, 
    "openid": "o6_bmjrPTlm6_2sgVt7hMZOPfL2M", 
    "nickname": "Band", 
    "sex": 1, 
    "language": "zh_CN", 
    "city": "广州", 
    "province": "广东", 
    "country": "中国", 
    "headimgurl":"":"http://thirdwx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
 ",
    "subscribe_time": 1382694957,
    "unionid": " o6_bmasdasdsad6_2sgVt7hMZOPfL"
    "remark": "",
    "groupid": 0,
    "tagid_list":[128,2],
    "subscribe_scene": "ADD_SCENE_QR_CODE",
    "qr_scene": 98765,
    "qr_scene_str": ""
}';

    }
}