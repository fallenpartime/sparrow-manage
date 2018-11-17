<?php
/**
 * 管理员服务
 * Date: 2018/10/23
 * Time: 14:43
 */
namespace Admin\Services\Master;

use Common\Models\System\AdminUser;

class MasterService
{
    /**
     * 管理员列表
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function masterList()
    {
        return AdminUser::whereHas('userInfo', function ($query) {
            $query->where(['is_admin' => 1, 'is_owner' => 1]);
        })->get();
    }
}
