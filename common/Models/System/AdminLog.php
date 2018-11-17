<?php

namespace Common\Models\System;

use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    protected $table = "admin_logs";

    public function user()
    {
        return $this->belongsTo(AdminUser::class, 'user_id');
    }
}
