<?php

namespace Common\Models\System;

use Illuminate\Database\Eloquent\Model;

class AdminUserInfo extends Model
{
    protected $table = "admin_user_infos";

    public function user()
    {
        return $this->belongsTo(AdminUser::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->hasOne(AdminUserRole::class, 'role_no', 'role_id');
    }

    public function userAction()
    {
        return $this->hasOne(AdminUserAction::class, 'user_id', 'user_id');
    }
}
