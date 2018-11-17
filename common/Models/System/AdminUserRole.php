<?php

namespace Common\Models\System;

use Illuminate\Database\Eloquent\Model;

class AdminUserRole extends Model
{
    protected $table = "admin_user_roles";

    public function accesses()
    {
        return $this->hasMany(AdminUserRoleAccess::class, 'role_no', 'role_no');
    }
}
