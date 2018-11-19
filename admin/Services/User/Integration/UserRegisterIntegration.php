<?php
/**
 * 用户注册
 * Date: 2018/11/18
 * Time: 16:56
 */
namespace Admin\Services\User\Integration;

use Admin\Services\User\Processor\UserInfoProcessor;
use Admin\Services\User\Processor\UserProcessor;
use Carbon\Carbon;
use Common\Models\User\User;
use Frameworks\Services\Basic\Processor\BaseWorkProcessor;
use Overtrue\Socialite\User as SocialiteUser;

class UserRegisterIntegration extends BaseWorkProcessor
{
    protected $userData = [];
    protected $userModel = null;

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
            return $this->parseResult('', [], 0);
        }
        $openId = array_get($userData, 'openid');
        if (empty($openId)) {
            return $this->parseResult('openid为空', [], 0);
        }
        $this->userModel = User::withTrashed()->where(['openid'=>$openId])->first();
        if (!empty($this->userModel) && empty($this->userModel->deleted_at)) {
            return $this->parseResult('用户已存在', [], 0);
        }
        list($user, $userId) = $this->processUser();
        if (empty($user)) {
            $this->status = 1;
            return $this->parseResult('', $user, $userId);
        }
        return $this->parseResult('用户添加失败', [], 0);
    }

    protected function processUser()
    {
        if (empty($this->userModel)) {
            // 新增
            list($socialiteUser, $userId) = $this->insertUser();
        } else {
            list($socialiteUser, $userId) = $this->updateUser();
        }
        return [$socialiteUser, $userId];
    }

    protected function initUserData()
    {
        $userData = $this->userData;
        $subscribedAt = null;
        if (!empty($userData['subscribe']) && !empty($userData['subscribe_time'])) {
            $subscribedAt = date('Y-m-d H:i:s', $userData['subscribe_time']);
        }
        $data = [
            'nick_name' =>  array_get($userData,  'nickname', ''),
            'openid'    =>  trim(array_get($userData,  'openid', '')),
            'unionid'   =>  trim(array_get($userData,  'unionid', '')),
            'face'      =>  trim(array_get($userData,  'headimgurl', '')),
            'last_login_at' =>  Carbon::now(),
            'is_subscribe'  =>  intval($userData['subscribe']),
            'subscribed_at' =>  $subscribedAt,
        ];
        $infoData = [
            'province'  =>  array_get($userData,  'province', ''),
            'city'      =>  array_get($userData,  'city', ''),
            'gender'    =>  array_get($userData,  'sex', 0),
        ];
        return [$data, $infoData];
    }

    protected function createSocialiteUser($user)
    {
        $user = new SocialiteUser([
            'id' => $user->openid,
            'name' => $user->nick_name,
            'nickname' => $user->nick_name,
            'avatar' => $user->face,
            'email' => null,
            'original' => [],
            'provider' => 'WeChat',
        ]);
        return $user;
    }

    protected function insertUser()
    {
        $userProcessor = new UserProcessor();
        $userInfoProcessor = new UserInfoProcessor();
        list($data, $infoData) = $this->initUserData();
        list($status, $model) = $userProcessor->insert($data);
        if ($status) {
            $infoData['user_id'] = $model->id;
            $userInfoProcessor->insert($infoData);
            return [$this->createSocialiteUser($model), $model->id];
        }
        return [null, 0];
    }

    protected function updateUser()
    {
        $this->userModel->restore();
        list($data, $infoData) = $this->initUserData();
        $userProcessor = new UserProcessor();
        $userInfoProcessor = new UserInfoProcessor();
        list($status, $userId) = $userProcessor->update($this->userModel->id, $data);
        if ($status) {
            $userInfoProcessor->updateWhere(['user_id'=>$userId], $infoData);
            return [$this->createSocialiteUser($this->userModel), $userId];
        }
        return [null, 0];;
    }
}