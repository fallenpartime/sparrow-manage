<?php

namespace Common\Models\System;

use Illuminate\Database\Eloquent\Model;

class AdminUserRoleAccess extends Model
{
    protected $table = "admin_user_role_accesses";

    public function group()
    {
        return $this->belongsTo(AdminUserGroup::class, 'group_no', 'group_no');
    }

    public function role()
    {
        return $this->belongsTo(AdminUserRole::class, 'role_no', 'role_no');
    }
}
