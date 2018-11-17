<?php

namespace Common\Models\System;

use Illuminate\Database\Eloquent\Model;

class AdminUser extends Model
{
    protected $table = "admin_users";

    public function userInfo()
    {
        return $this->hasOne(AdminUserInfo::class, 'user_id');
    }
}
